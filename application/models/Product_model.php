<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends CI_Model {

    public function get_products() {
        return $this->db->get('products')->result();
    }

    public function get_product($id) {
        return $this->db->get_where('products', ['id' => $id])->row();
    }

    public function create_product($data) {
        return $this->db->insert('products', $data);
    }

    public function update_product($id, $data) {
        return $this->db->where('id', $id)->update('products', $data);
    }

    public function delete_product($id) {
        return $this->db->where('id', $id)->delete('products');
    }

    // DataTable Methods
    public function get_datatable($start, $length, $search, $order) {
        $this->db->limit($length, $start);
        
        if(!empty($search)) {
            $this->db->group_start();
            $this->db->like('name', $search);
            $this->db->or_like('description', $search);
            $this->db->or_like('category', $search);
            $this->db->group_end();
        }
        
        if(!empty($order)) {
            $columns = ['id', 'name', 'price', 'category'];
            $this->db->order_by($columns[$order[0]['column']], $order[0]['dir']);
        }
        
        return $this->db->get('products')->result();
    }
    
    public function count_all() {
        return $this->db->count_all('products');
    }
    
    public function count_filtered($search) {
        if(!empty($search)) {
            $this->db->group_start();
            $this->db->like('name', $search);
            $this->db->or_like('description', $search);
            $this->db->or_like('category', $search);
            $this->db->group_end();
        }
        return $this->db->get('products')->num_rows();
    }
}