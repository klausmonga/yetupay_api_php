<?php

namespace yetupay\api;

class ProcessPayment {
    private $dev;
    private $bill_to;
    private $p_info;
    private $run_env;
    private $JSONObject_trans;
    private $productsList="";
    private $JSONObject_response;
    public function getDev() {
        return $this->dev;
    }

    public function addDev($client_id, $client_secret, $num, $pwd) {
        $this->dev = "\"dev\":{\n" .
                "\t  \t\"num\":\"".$num."\",\n" .
                "\t\t\"pwd\":\"".$pwd."\",\n" .
                "\t\t\"client_id\":\"".$client_id."\",\n" .
                "\t\t\"client_secret\":\"".$client_secret."\"\n" .
                "\t  \t\n" .
                "\t  }";
    }

    public function getBill_to() {
        return $this->bill_to;
    }

    public function addBill_to($num) {
        $this->bill_to = "\"bill_to\":{\n" .
                "\t  \t\"num\":\"".$num."\"}";
    }

    public function getP_info() {
        return $this->p_info;
    }
    public function addProduct($receiver,$price, $quantity,$name,$description){
        $this->productsList.=",{\"receiver\":\"".$receiver."\",\"price\":".$price.",\"quantity\":".$quantity.",\"name\":\"".$name."\",\"description\":\"".$description."\"}";
    }
    public function getProductsList(){
        return $this->productsList;
    }
    public function addP_info($currency,$tax) {
        $products = $this->getProductsList();
        $products[0] = " ";
        $this->p_info = "\"p_info\":{\"products\":[".$products."],\"currency\":\"".$currency."\",\"tax\":".$tax."}";
    }

    public function getRun_env() {
        return $this->run_env;
    }

    public function addRun_env($return_slip_format) {
        $this->run_env = " \"run_env\":{\n" .
                "\t  \t\"return_slip_format\":\"".$return_slip_format."\"\n" .
                "\t  }";
    }

    public function getTrans(){
        return "{\"trans\":{".$this->getDev().",".$this->getBill_to().",".$this->getP_info().",".$this->getRun_env()."}}";
    }

    public function setTrans($JSONObject_trans) {
        $this->trans = $JSONObject_trans;
    }
    public function commit(){                                                                    
        $data_string = $this->getTrans();                                                                                   
                                                                                                                            
        $ch = curl_init('https://yetupay.com/Api/process_payment');                                                                      
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
            'Content-Type: application/json',                                                                                
            'Content-Length: ' . strlen($data_string))                                                                       
        );                                                                                                                   
                                                                                                                            
        $result = curl_exec($ch);
        return $result;
    }
    
}

// $pp = new ProcessPayment();
// $pp->addDev("2fdf9a7d655a8d896f6b03a926d8a71799f2f2ccbb171386f5cc588ef7e7ab5c", "2fdf9a7d655a8d896f6b03a926d8a71799f2f2ccbb171386f5cc588ef7e7ab5c", "0970665096", "11111111");
// $pp->addProduct("0970665096",50, 1,"techno","telphone techno");
// $pp->addProduct("0970665096",30, 1,"tshirt","telphone t-shirt");
// $pp->addP_info("usd","16");
// $pp->addBill_to("0840246444");
// $pp->addRun_env("json");
// $pp->commit();


?>