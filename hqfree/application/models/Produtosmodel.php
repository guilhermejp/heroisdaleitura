<?php

require_once MODEL_BASE;

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ProdutosModel extends ModelBase 
{    

    function __construct() 
    {
        parent::__construct(DBGroup::MASTER_STORE, Model::$PRODUCT['model']);
    }

    public function GetProductById($productid=null)
    {
        $rows = NULL;                    			

        $this->db->select("p.*");                

        if(Tools::IsValid($productid)){
            $this->db->where(array('p.id' => $productid));
        }        
        
        $result = $this->db->get($this->GetDefaultTable(). ' AS p');
        

        if (Tools::IsValidObject($result))
        {
            $rows = $result->result();        
        }

        return $rows;
    }

    public function GetAllPromotion($languageid)
    {
        $rows = NULL;                    			

        $this->db->select("p.*"); 
        $this->db->join('category AS c', 'p.categoryid = c.categoryid', 'inner');
        $this->db->where('p.status', true);
        $this->db->where('p.promotion', 1);
                
        if(Tools::IsValid($languageid))
        {
            $this->db->where(array('c.languageid' => $languageid));
        }
        
        $this->db->limit(20);
        
        $result = $this->db->get($this->GetDefaultTable(). ' AS p');

        if (Tools::IsValidObject($result))
        {
            $rows = $result->result();        
        }

        return $rows;
    }

    public function GetAllRelease($languageid)
    {
        $rows = NULL;                    			

        $this->db->select("p.*"); 
        $this->db->join('category AS c', 'p.categoryid = c.categoryid', 'inner');
        $this->db->where('p.status', true);
        $this->db->where('p.release', 1);
                
        if(Tools::IsValid($languageid))
        {
            $this->db->where(array('c.languageid' => $languageid));
        }
        
        $this->db->limit(20);
        
        $result = $this->db->get($this->GetDefaultTable(). ' AS p');

        if (Tools::IsValidObject($result))
        {
            $rows = $result->result();        
        }

        return $rows;
    }

    public function GetAllRelated($productID)
    {
        $rows = NULL;                    			
        $result = $this->db->query("SELECT p.*
                                    FROM related as r
                                    INNER JOIN product p ON (r.relatedid = p.productid)
                                    WHERE r.productid = ".$productID."
                                    ORDER BY p.bestsellers = 1");

        if (Tools::IsValidObject($result))
        {
            $rows = $result->result();        
        }

        return $rows;
    }


    public function GetAllImages($productID)
    {
        $rows = NULL;                    			
        $result = $this->db->query("SELECT  pi.*,
                                            it.mnemonic,
                                            it.size
                                    FROM productimage pi 
                                    INNER JOIN imagetype it ON (pi.imagetypeid = it.imagetypeid)                                    
                                    AND pi.status = 't'
                                    ");
        
        

        if (Tools::IsValidObject($result))
        {
            $rows = $result->result();        
        }

        return $rows;
    }

    public function GetAllImagesDetailsByProduct($productID)
    {
        $rows = NULL;                    			
        $result = $this->db->query("SELECT  t.name as imagetypename,
                                            t.size as imagetypesize,
                                            r.name as relatedname,
	                                        r.path as relatedpath,
                                            img.*,
                                            split_part(u.name,' ',1) as userupdatename 
                                    FROM productimage img
                                    INNER JOIN users u ON(img.userupdate = u.usersid) 
                                    INNER JOIN imagetype t ON (img.imagetypeid = t.imagetypeid)
                                    LEFT JOIN productimage r ON (img.relatedid = r.productimageid)
                                    WHERE img.productid = " . $productID ."
                                    AND t.mnemonic = 'PDTDP'");
                                
        
        

        if (Tools::IsValidObject($result))
        {
            $rows = $result->result();        
        }

        return $rows;
    }
    
    public function GetAllByCategory($category)
    {
        $rows = NULL;                    			

        $this->db->select("p.*"); 
        $this->db->join('category AS c', 'p.categoryid = c.categoryid', 'inner');
        $this->db->where('p.status', true);
        $this->db->where('p.categoryid', $category);

        // if(Tools::IsValid($languageid))
        //     $this->db->where(array('c.languageid' => $languageid));

        $result = $this->db->get($this->GetDefaultTable(). ' AS p');
        

        if (Tools::IsValidObject($result))
        {
            $rows = $result->result();        
        }

        return $rows;
    }


    public function GetProductByCatAndDesc($category, $productName)
    {
        $rows = NULL;                               

        $this->db->select("p.*"); 
        $this->db->join('category AS c', 'p.categoryid = c.categoryid', 'inner');        
            
        if($category != 0){
            $this->db->where('p.categoryid', $category);
        }

        $this->db->like('upper(p.name)', strtoupper($productName));

        $result = $this->db->get($this->GetDefaultTable(). ' AS p');        

        if (Tools::IsValidObject($result))
        {
            $rows = $result->result();        
        }

        //echo "<pre>";
        //var_dump($rows);
        //die();

        return $rows;
    }

}