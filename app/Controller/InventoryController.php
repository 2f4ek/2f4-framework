<?php

namespace Framework2f4\Controller;

use Framework2f4\Http\Response;
use Framework2f4\Http\ServerRequest;
use Framework2f4\Model\Inventory;

class InventoryController
{
    public function create(ServerRequest $request): Response
    {
        $data = $request->getParsedBody();
        $inventory = new Inventory($data);
        $inventory->save();
        return new Response(201, [], 'Inventory item created');
    }

    public function list(): Response
    {
        $items = Inventory::all();
        return Response::json($items);
    }

    public function delete(int $id): Response
    {
        $item = Inventory::find($id);
        if ($item) {
            $item->delete();
            return new Response(200, [], 'Inventory item deleted');
        }
        return new Response(404, [], 'Item not found');
    }

    public function update(ServerRequest $request, int $id): Response
    {
        $data = $request->getParsedBody();
        $item = Inventory::find($id);
        if ($item) {
            foreach ($data as $key => $value) {
                $item->$key = $value;
            }
            $item->save();
            return new Response(200, [], 'Inventory item updated');
        }
        return new Response(404, [], 'Item not found');
    }
}