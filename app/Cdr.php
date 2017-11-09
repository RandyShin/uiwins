<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cdr extends Model
{
    protected $table = 'cdr';

    public function getType()
    {
        if(substr($this->dst, 0,2)==='01'){
            return "<font color='blue'>무선</font>";
        }
        if(substr($this->dst, 0,2)==='86'){
            return "중국";
        }
        if((substr($this->dst, 0,3)==='070') || (substr($this->dst,0,3) === '050' )) {
            return  "특수";
        }
        if((substr($this->dst, 0,2)!='01') && (substr($this->dst,0,2) != '86' ) && (substr($this->dst,0,3) != '070' ) && (substr($this->dst,0,3) != '050' )) {
            return  "<font color='green'>유선</font>";
        }
    }
    
    public function getUnit()
    {
        if(substr($this->dst, 0,2)==='01'){
            return ceil($this->billsec/10);
        }
        if(substr($this->dst, 0,2)==='86'){
            return ceil($this->billsec/60);
        }
        if((substr($this->dst, 0,3)==='070') || (substr($this->dst,0,3) === '050' )) {
            return ceil($this->billsec/180);
        }
        if((substr($this->dst, 0,2)!='01') && (substr($this->dst,0,2) != '86' ) && (substr($this->dst,0,3) != '070' ) && (substr($this->dst,0,3) != '050' )) {
            return ceil($this->billsec/180);
        }
    }

    public function getPrice()
    {
        if(substr($this->dst, 0,2)==='01'){
            return ceil($this->billsec/10)*6.8;
        }
        if(substr($this->dst, 0,2)==='86'){
            return ceil($this->billsec/60)*22;
        }
        if((substr($this->dst, 0,3)==='070') || (substr($this->dst,0,3) === '050' )) {
            return ceil($this->billsec/180)*45;
        }
        if((substr($this->dst, 0,2)!='01') && (substr($this->dst,0,2) != '86' ) && (substr($this->dst,0,3) != '070' ) && (substr($this->dst,0,3) != '050' )) {
            return ceil($this->billsec/180)*32;
        }
    }

//    public function getTotal()
//    {
//        $total = 0;
//        $count = 0;
////        $total_count = Cdr::count();
//        while ( ++$count <= 525)
//        {
//            if(substr($this->dst, 0,2)==='01'){
//                $total = $total + ceil($this->billsec/10)*6.8;
//            }
//            if(substr($this->dst, 0,2)==='86'){
//                $total = $total + ceil($this->billsec/60)*22;
//            }
//            if((substr($this->dst, 0,3)==='070') || (substr($this->dst,0,3) === '050' )) {
//                $total = $total + ceil($this->billsec/180)*45;
//            }
//            if((substr($this->dst, 0,2)!='01') && (substr($this->dst,0,2) != '86' ) && (substr($this->dst,0,3) != '070' ) && (substr($this->dst,0,3) != '050' )) {
//                $total = $total + ceil($this->billsec/180)*32;
//            }
//        }
//        return $total ;
//    }
}
