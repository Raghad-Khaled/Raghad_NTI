<?php

namespace App\Database\Models;

use App\Database\Models\Contract\HasCrud;
use App\Database\Models\Model;

class Product extends Model implements HasCrud
{
    private $id,$name_ar,$name_en,$price,$product_code,$quentity,$status,$image,
        $details_ar, $details_en, $brand_id, $subcategory_id, $created_at, $updated_at, $category_id;

    
    public function create() : bool
    {
        return true;
    }


    public function read() : \mysqli_result
    {
        $query = "SELECT id,name_en,details_en,price,image FROM products WHERE status = 1 ORDER BY price , name_en";
        return $this->conn->query($query);
    }

    public function getnews(): \mysqli_result
    {
        $query = "SELECT * FROM products WHERE status = 1 ORDER BY created_at DESC LIMIT 4";
        return $this->conn->query($query);   
    }

    public function getbest(): \mysqli_result
    {
        $query = "SELECT
        products.id,
        products.name_en,
        products.image,
        products.price,
        COUNT(products.id) as ordertimes
        FROM
            products
        JOIN order_product ON order_product.product_id = products.id
        GROUP BY products.id
        ORDER BY ordertimes DESC
        LIMIT 4";
        return $this->conn->query($query);
    }

    public function update(): bool
    {
        return true;
    }

    public function delete(): bool
    {
        return true;
    }

    public function getProductsByBrand(): \mysqli_result
    {
        $query = "SELECT id,name_en,details_en,price,image FROM products WHERE status = 1 AND brand_id = ? ORDER BY price , name_en";
        $stmt =  $this->conn->prepare($query);
        $stmt->bind_param('i', $this->brand_id);
        $stmt->execute();
        return $stmt->get_result();
    }
    public function getProductsBySub(): \mysqli_result
    {
        $query = "SELECT id,name_en,details_en,price,image FROM products WHERE status = 1 AND subcategory_id = ? ORDER BY price , name_en";
        $stmt =  $this->conn->prepare($query);
        $stmt->bind_param('i', $this->subcategory_id);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function find(): \mysqli_result
    {
        $query = "SELECT products.*,AVG(reviews.rate) as reviews_avg,
        COUNT(reviews.user_id) as reviews_count,subcategories.name_en as subcategory_name_en,brands.name_en as brand_name_en,
        categories.id as category_id,categories.name_en as category_name_en
        FROM products
        JOIN reviews
        ON product_id = products.id
        JOIN subcategories
        ON subcategories.id=subcategory_id
        JOIN brands
        ON brands.id=brand_id
        JOIN categories
        ON categories.id= subcategories.category_id
        WHERE products.status = 1 
        GROUP BY  products.id
        HAVING products.id=?";
        $stmt =  $this->conn->prepare($query);
        $stmt->bind_param('i', $this->id);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function getProductsByCat(): \mysqli_result
    {
        $query = "SELECT products.id,products.name_en,products.details_en,products.price,products.image FROM products
        JOIN subcategories ON 
        subcategories.id = products.subcategory_id
        WHERE products.status = 1 AND  subcategories.category_id= ? ORDER BY price , name_en";
        $stmt =  $this->conn->prepare($query);
        $stmt->bind_param('i', $this->category_id);
        $stmt->execute();
        return $stmt->get_result();
    }
    
    

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of name_ar
     */ 
    public function getName_ar()
    {
        return $this->name_ar;
    }

    /**
     * Set the value of name_ar
     *
     * @return  self
     */ 
    public function setName_ar($name_ar)
    {
        $this->name_ar = $name_ar;

        return $this;
    }

    /**
     * Get the value of name_en
     */ 
    public function getName_en()
    {
        return $this->name_en;
    }

    /**
     * Set the value of name_en
     *
     * @return  self
     */ 
    public function setName_en($name_en)
    {
        $this->name_en = $name_en;

        return $this;
    }

    /**
     * Get the value of product_code
     */ 
    public function getProduct_code()
    {
        return $this->product_code;
    }

    /**
     * Set the value of product_code
     *
     * @return  self
     */ 
    public function setProduct_code($product_code)
    {
        $this->product_code = $product_code;

        return $this;
    }

    /**
     * Get the value of quentity
     */ 
    public function getQuentity()
    {
        return $this->quentity;
    }

    /**
     * Set the value of quentity
     *
     * @return  self
     */ 
    public function setQuentity($quentity)
    {
        $this->quentity = $quentity;

        return $this;
    }

    /**
     * Get the value of status
     */ 
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @return  self
     */ 
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get the value of image
     */ 
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set the value of image
     *
     * @return  self
     */ 
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get the value of details_ar
     */ 
    public function getDetails_ar()
    {
        return $this->details_ar;
    }

    /**
     * Set the value of details_ar
     *
     * @return  self
     */ 
    public function setDetails_ar($details_ar)
    {
        $this->details_ar = $details_ar;

        return $this;
    }

    /**
     * Get the value of details_en
     */ 
    public function getDetails_en()
    {
        return $this->details_en;
    }

    /**
     * Set the value of details_en
     *
     * @return  self
     */ 
    public function setDetails_en($details_en)
    {
        $this->details_en = $details_en;

        return $this;
    }

    /**
     * Get the value of brand_id
     */ 
    public function getBrand_id()
    {
        return $this->brand_id;
    }

    /**
     * Set the value of brand_id
     *
     * @return  self
     */ 
    public function setBrand_id($brand_id)
    {
        $this->brand_id = $brand_id;

        return $this;
    }

    /**
     * Get the value of price
     */ 
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set the value of price
     *
     * @return  self
     */ 
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get the value of subcategory_id
     */ 
    public function getSubcategory_id()
    {
        return $this->subcategory_id;
    }

    /**
     * Set the value of subcategory_id
     *
     * @return  self
     */ 
    public function setSubcategory_id($subcategory_id)
    {
        $this->subcategory_id = $subcategory_id;

        return $this;
    }

    /**
     * Get the value of created_at
     */ 
    public function getCreated_at()
    {
        return $this->created_at;
    }

    /**
     * Set the value of created_at
     *
     * @return  self
     */ 
    public function setCreated_at($created_at)
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * Get the value of updated_at
     */ 
    public function getUpdated_at()
    {
        return $this->updated_at;
    }

    /**
     * Set the value of updated_at
     *
     * @return  self
     */ 
    public function setUpdated_at($updated_at)
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * Get the value of category_id
     */
    public function getCategory_id()
    {
        return $this->category_id;
    }

    /**
     * Set the value of category_id
     *
     * @return  self
     */
    public function setCategory_id($category_id)
    {
        $this->category_id = $category_id;

        return $this;
    }
}