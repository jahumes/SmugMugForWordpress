<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of pagination
 *
 * @author Anthony Humes
 */
class SMW_Helpers_Pagination {
    public $current_page;
    public $per_page;
    private $total_count;
    public $offset;
    public function __construct() {
        
    }
    public function load( $page = 1, $per_page = 20, $total_count = 0, $range = 2 ) {
        $this->current_page = $page;
        $this->per_page = $per_page;
        $this->range = $range;
        $this->total_count = $total_count;
        $this->total_pages = $this->totalPages();
        $this->offset = $this->offset();
    }
    private function totalPages() {
        if($this->per_page == 0) {
  		$this->total_count = 1;
  	} else {
            return ceil($this->total_count/$this->per_page); 		
  	}
    }
    private function offset() {
        // Assuming 20 items per page:
        // page 1 has an offset of 0    (1-1) * 20
        // page 2 has an offset of 20   (2-1) * 20
        //   in other words, page 2 starts with item 21
        return ($this->current_page - 1) * $this->per_page;
    }
    public function itemsPerPage( $item_array ) {
        $this->per_page_items = $item_array;
        //print_r($this->per_page_items);
        SMW::getBlock('helpers/pagination/items-per-page');
    }
    public function previousPage() {
        return $this->current_page - 1;
    }

    public function nextPage() {
        return $this->current_page + 1;
    }
    public function hasPreviousPage() {
        return $this->previousPage() >= 1 ? true : false;
    }

    public function hasNextPage() {
        return $this->nextPage() <= $this->totalPages() ? true : false;
    }
    public function ajaxPagination() {
        SMW::getBlock('helpers/pagination/ajax-pages');
    }
}