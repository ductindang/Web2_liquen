<?php
    class CustomerRepository extends BaseRepository{
        function fetchAll($condition = null){

            global $conn;
            $customers = array();
            $sql = "SELECT * FROM user";

            if($condition){
                $sql .= " WHERE $condition";
            }

            $result = $conn->query($sql);
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    $customer = new Customer($row["id"], $row["role_id"], $row["name"], $row["mobile"], $row["email"], $row["password"], $row["updated_at"], $row["created_at"], $row["is_active"], $row["address"], $row["ward_id"]);
                    $customers[] = $customer;
                }
            }
            return $customers;

        }

        function getAll(){
            return $this->fetchAll();
        }

        function findEmail($email){
            global $conn;
            $condition = "email = '$email'";
            $customers = $this->fetchAll($condition);
            $customer = current($customers);
            return $customer;
        }

        function findEmailAndPassword($email, $password) {
            global $conn; 
            $condition = "email = '$email' AND password = '$password'";
            $customers = $this->fetchAll($condition);
            $customer = current($customers);
            return $customer;
        }

        function update($customer){
            global $conn;
            $id = $customer->getId();
            $role_id = $customer->getRoleId();
            $name = $customer->getName();
            $mobile = $customer->getMobile();
            $email = $customer->getEmail();
            $password = $customer->getPassword();
            $updated_at = $customer->getUpdatedAt();
            $created_at = $customer->getCreatedAt();

            $is_active = $customer->getIsActive();
            $address = $customer->getAddress();
            $ward_id = $customer->getWardId();

            if (empty($ward_id)) {
                $ward_id = "NULL";
            }
            else {
                $ward_id = "'$ward_id'";
            }
    
            if (empty($is_active)) {
                $is_active = 0;
            }

            $sql = "UPDATE user
                SET role_id=$role_id, name='$name', mobile='$mobile', email='$email',
                    password='$password', updated_at='$updated_at', created_at='$created_at',
                    is_active=$is_active, address='$address', ward_id=$ward_id Where id=$id";

            if ($conn->query($sql) === TRUE){
                return true;
            }
            $this->error = "Error: " . $sql . PHP_EOL . $conn->error;
            return false;
        }


        function find($id) {
            global $conn; 
            $condition = "id = $id";
            $customers = $this->fetchAll($condition);
            $customer = current($customers);
            return $customer;
        }
    }


?>