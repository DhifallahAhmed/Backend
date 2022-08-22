<?php

namespace App\Http\Controllers;
use App\Models\HeureSup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\user;

class HeureSupController extends Controller
{
    public function getHeure($id){
        $user=User::where('user_id','=',$id)->first();
        if($user->isAdmin)
        {return response()->json(HeureSup::all(),200);}
        else{
            return response()->json(HeureSup::where('user_id','=',$id)->get(),200);
        }
   }

   public function getHeureById ($id){
        $heureSup = HeureSup::find($id);
        if(is_null($heureSup)){
            return response()->json(['message' => 'HeureSup Not Found'], 404);
        }
        return response()->json($heureSup::find($id), 200);
   }

   public function updateHeure(Request $request, $id){
    $heureSup = HeureSup::find($id);
    if(is_null($heureSup)){
        return response() -> json(['message' => 'HeureSup Not Found'],404);
    }
    $heureSup->update($request->all());
}
    public function deleteHeure(Request $request, $id){
    $heureSup = HeureSup::find($id);
    if(is_null($heureSup)){
        return response() -> json(['message' => 'HeureSup Not Found'],404);
    }
    $heureSup->delete();
    return response()->json(null,204);

}
    public function addHeure(Request $request){
        $heure = HeureSup::create($request->all());
        return response($heure,201);
    }


}
