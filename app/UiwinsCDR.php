<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class UiwinsCDR extends Model
{
    protected $table = 'cdr';

    public function custom_query() {  //show only 40 channels(benjamin request)
        $result = DB::table('cdr')->where('did','LIKE','02849%');
        return $result;
    }
}
