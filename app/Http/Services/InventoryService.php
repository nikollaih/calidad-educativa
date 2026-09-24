<?php

namespace App\Http\Services;

use App\DTOs\Result;
use App\Models\Inventory;
use Exception;

class InventoryService {

    public function create(array $data):Result {
        try {
            $inventory = Inventory::create($data);
            if($inventory)
                return Result::success('Elemento de inventario creado con éxito', $inventory);
        } catch (Exception $e) {
            return Result::error($e->getMessage());
        }
    }
    public function syncInventory(array $inventoryArray, int $sedeId): void {
            $ids = [];
            // Recorre los registros
            foreach ($inventoryArray as $key => $inventory) {

                if (!is_array($inventory) || empty($inventory) || empty($inventory['quantity'])) {
                    continue;
                }
                $inventory['sede_id']= $sedeId;
                // Syncroniza el registro
                $inventoryCreated = Inventory::updateOrCreate($inventory, $inventory);

                array_push($ids, $inventoryCreated->id);
            }
            // Elimina los sobrantes
            Inventory::where('sede_id',$sedeId)->whereNotIn('id', $ids)->delete();


    }

}
