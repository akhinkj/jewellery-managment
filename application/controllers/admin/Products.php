<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if(!$this->session->userdata('logged_in')) {
            redirect('index.php/auth/login');
        }
        $this->load->model('Product_model');
        $this->load->library(['upload', 'image_lib', 'form_validation']);
    }

    // List Products with DataTable
    public function index() {
        $data = [
            'content' => 'admin/products/list',
            'products' => $this->Product_model->get_products()
        ];
        $this->load->view('admin/template', $data);
    }

    // Create Product
    public function create() {
        $data = [
            'content' => 'admin/products/create',
            'categories' => ['Ring', 'Necklace', 'Bracelet', 'Earring']
        ];

        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('description', 'Description', 'required');
        $this->form_validation->set_rules('price', 'Price', 'required|numeric');
        $this->form_validation->set_rules('category', 'Category', 'required');

        if($this->form_validation->run() && $this->input->post()) {
            $upload = $this->_handle_image_upload();
            
            if($upload['status']) {
                $post_data = $this->input->post();
                $post_data['image'] = $upload['file_name'];

                if($this->Product_model->create_product($post_data)) {
                    $this->session->set_flashdata('success', 'Product created successfully');
                    redirect('index.php/admin/products');
                }
            }
            $this->session->set_flashdata('error', $upload['error'] ?? 'Error creating product');
        }

        $this->load->view('admin/template', $data);
    }

    // Edit Product
    public function edit($id) {
        $product = $this->Product_model->get_product($id);
        $data = [
            'content' => 'admin/products/edit',
            'product' => $product,
            'categories' => ['Ring', 'Necklace', 'Bracelet', 'Earring']
        ];

        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('description', 'Description', 'required');
        $this->form_validation->set_rules('price', 'Price', 'required|numeric');
        $this->form_validation->set_rules('category', 'Category', 'required');

        if($this->form_validation->run() && $this->input->post()) {
            $post_data = $this->input->post();
            
            if($_FILES['image']['name']) {
                $upload = $this->_handle_image_upload();
                if($upload['status']) {
                    $post_data['image'] = $upload['file_name'];
                    // Delete old image
                    @unlink("./uploads/products/{$product->image}");
                }
            }

            if($this->Product_model->update_product($id, $post_data)) {
                $this->session->set_flashdata('success', 'Product updated successfully');
                redirect('index.php/admin/products');
            }
            $this->session->set_flashdata('error', 'Error updating product');
        }

        $this->load->view('admin/template', $data);
    }

    // Delete Product
    public function delete($id) {
        $product = $this->Product_model->get_product($id);
        if($product) {
            @unlink("./uploads/products/{$product->image}");
            $this->Product_model->delete_product($id);
            $this->session->set_flashdata('success', 'Product deleted successfully');
        }
        redirect('index.php/admin/products');
    }

    // AJAX DataTable Endpoint
    public function ajax_list() {
        $draw = $this->input->get('draw');
        $start = $this->input->get('start');
        $length = $this->input->get('length');
        $search = $this->input->get('search')['value'];
        $order = $this->input->get('order');

        $output = [
            "draw" => intval($draw),
            "recordsTotal" => $this->Product_model->count_all(),
            "recordsFiltered" => $this->Product_model->count_filtered($search),
            "data" => $this->Product_model->get_datatable($start, $length, $search, $order)
        ];

        echo json_encode($output);
    }

    // Image Upload Handler
    private function _handle_image_upload() {
        $config = [
            'upload_path'   => './uploads/products/',
            'allowed_types' => 'jpg|jpeg|png',
            'max_size'      => 2048,
            'encrypt_name' => TRUE
        ];

        $this->upload->initialize($config);

        if(!$this->upload->do_upload('image')) {
            return ['status' => false, 'error' => $this->upload->display_errors()];
        }

        $image_data = $this->upload->data();

        // Resize Image
        $config = [
            'image_library'  => 'gd2',
            'source_image'   => $image_data['full_path'],
            'maintain_ratio' => TRUE,
            'width'          => 500,
            'height'         => 500
        ];

        $this->image_lib->initialize($config);
        if(!$this->image_lib->resize()) {
            return ['status' => false, 'error' => $this->image_lib->display_errors()];
        }

        return ['status' => true, 'file_name' => $image_data['file_name']];
    }
}