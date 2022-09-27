<?php

namespace App\Database\Models;

use App\Database\Models\Contract\HasCrud;

class Review extends Model  implements HasCrud
{
    private $product_id, $user_id, $rate, $comment, $created_at, $updated_at;
    public function create(): bool
    {
        $query = "INSERT INTO `reviews`(`product_id`, `user_id`, `rate`, `comment`) VALUES (?,?,?,?)";
        $stmt =  $this->conn->prepare($query);
        $stmt->bind_param('iiis', $this->product_id, $this->user_id, $this->rate, $this->comment);
        return $stmt->execute();
    }

    public function update(): bool
    {
        $query = "UPDATE `reviews` SET `rate`=?,`comment`=? WHERE `product_id`=? and `user_id`=?";
        $stmt =  $this->conn->prepare($query);
        $stmt->bind_param('isii', $this->rate, $this->comment, $this->product_id, $this->user_id);
        return $stmt->execute();
    }

    public function delete(): bool
    {
        return true;
    }

    public function read(): \mysqli_result
    {
        $query = "SELECT
                    `reviews`.*,
                    CONCAT(`users`.`first_name` , ' ' , `users`.`last_name`) AS `full_name`
                FROM
                    `reviews`
                JOIN `users`
                ON `users`.`id` = `reviews`.`user_id`
                WHERE
                    `product_id` = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $this->product_id);
        $stmt->execute();
        return $stmt->get_result();
    }


    /**
     * Get the value of product_id
     */
    public function getProduct_id()
    {
        return $this->product_id;
    }

    /**
     * Set the value of product_id
     *
     * @return  self
     */
    public function setProduct_id($product_id)
    {
        $this->product_id = $product_id;

        return $this;
    }

    /**
     * Get the value of user_id
     */
    public function getUser_id()
    {
        return $this->user_id;
    }

    /**
     * Set the value of user_id
     *
     * @return  self
     */
    public function setUser_id($user_id)
    {
        $this->user_id = $user_id;

        return $this;
    }

    /**
     * Get the value of rate
     */
    public function getRate()
    {
        return $this->rate;
    }

    /**
     * Set the value of rate
     *
     * @return  self
     */
    public function setRate($rate)
    {
        $this->rate = $rate;

        return $this;
    }

    /**
     * Get the value of comment
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set the value of comment
     *
     * @return  self
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

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
}
