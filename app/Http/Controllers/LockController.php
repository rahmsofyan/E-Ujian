<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\kunci;

class LockController extends Controller
{
   public function getStatus()
   {
   		$kunci = kunci::first();
   	 	return response()->json($kunci->status);
   }

   public function setStatusSatu()
   {
   		$kunci = kunci::first();
   		$kunci->status = 1;
   		$kunci->save();
   		return response()->json($kunci->status);
   }

   public function setStatusNol()
   {
   		$kunci = kunci::first();
   		$kunci->status = 0;
   		$kunci->save();
   		return response()->json($kunci->status);
   }
}
