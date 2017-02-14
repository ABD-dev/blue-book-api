<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use JWTAuth;
use App\Item;
use Dingo\Api\Routing\Helpers;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ItemsController extends Controller
{
  use Helpers;

  public function index(Request $request) {
    $currentUser = JWTAuth::parseToken()->authenticate();
    return $currentUser
        ->items()
        ->if($request->barcode, 'barcode', '=', $request->barcode)
        ->if($request->name, 'name', '=', $request->name)
        ->when($request->only, function($query) use ($request) {
          return $query->select([$request->only]);
        })
        ->orderBy('created_at', 'DESC')
        ->get()
        ->toArray();
  }

  public function store(Request $request) {
    $currentUser = JWTAuth::parseToken()->authenticate();

    $item = new Item;

    $item->barcode = $request->get('barcode');
    $item->name = $request->get('name');
    $item->description = $request->get('description');
    $item->amount_in = $request->get('amount_in');
    $item->amount_out = $request->get('amount_out');
    $item->value_in = $request->get('value_in');
    $item->value_out = $request->get('value_out');
    $item->expiry_date = $request->get('expiry_date');

    if($currentUser->items()->save($item)){
      return $item;
    } else {
      return $this->response->error('Could not create item', 500);
    }
  }

  public function show($id) {
    $currentUser = JWTAuth::parseToken()->authenticate();

    $item = $currentUser->items()->find($id);

    if(!$item){
      throw new NotFoundHttpException;
    }

    return $item;
  }

  public function update(Request $request, $id) {
    $currentUser = JWTAuth::parseToken()->authenticate();

    $item = $currentUser->items()->find($id);
    if(!$item)
        throw new NotFoundHttpException;

    $item->fill($request->all());

    if($item->save()){
      return $item;
    } else {
      return $this->response->error('Could not update item', 500);
    }
  }

  public function destroy($id) {
    $currentUser = JWTAuth::parseToken()->authenticate();

    $item = $currentUser->items()->find($id);

    if(!$item){
      throw new NotFoundHttpException;
    }

    if($item->delete()){
      return $this->response->noContent();
    } else {
      return $this->response->error('Could not delete item', 500);
    }
  }

  // public function ItemsListName() {
  //   $currentUser = JWTAuth::parseToken()->authenticate();
  //   return $currentUser
  //       ->items()
  //       ->orderBy('name', 'ASC')
  //       ->get(['name'])
  //       ->toArray();
  // }

}
