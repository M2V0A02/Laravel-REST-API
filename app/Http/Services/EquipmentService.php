<?php
namespace App\Http\Services;

use App\Http\Requests\SaveEquipmentRequest;
use App\Http\Requests\UpdateEquipmentRequest;
use App\Models\Equipment;

/**
 * Сервис оборудования
 */
class EquipmentService
{
    /**
     * Получить список оборудования с пагинацией и поиском
     *
     * @param int    $per_page      Число элементов на странице
     * @param string $serial_number Серийный номер оборудования
     * @param string $desc          Описание оборудования
     * @param string $q             Поиск по нескольким столбцам
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator Список оборудования с пагинацией
     */
    public function index(int $per_page = 10, string $serial_number = '', string $desc = '', string $q = '') 
    {
        if (is_numeric($per_page) && $per_page <= 0)
            $per_page = 10;
        
        $query = Equipment::query();
        
        if ($q !== '')
            return $query
                    ->where('serial_number', 'LIKE', "%$q%")
                    ->orWhere('desc', 'LIKE', "%$q%")
                    ->paginate($per_page);
        
        if ($serial_number !== '') 
            $query->where('serial_number', 'LIKE', "%$serial_number%");
        if ($desc !== '')
            $query->where('desc', 'LIKE', "%$desc%");
        
        return $query->paginate($per_page);
    }

    /**
     * Сохранить оборудование
     *
     * @param SaveEquipmentRequest $request Запрос на сохранение оборудования.
     *
     * @return array Массив, содержащий два ключа: "success", который содержит массив проверенных данных, соответствующих оборудованию, и "errors", который содержит массив ошибок валидации.
     */
    public function saveEquipment(SaveEquipmentRequest $request):array
    {
        foreach($request->validated() as $equipment)
            $equipment->save();
        
        return [
            "success" => $request->validated(),
            "errors" => $request->errors()
        ];
    }

     /**
    * Обновляет данные оборудования.
    *
    * @param UpdateEquipmentRequest $request запрос обновления ресурса.
    * @return array Если не удалось выполнить обновление, возвращает массив с сообщением об ошибке.
    * В случае успешного выполнения возвращает успешное сообщение.
    */
    public function updateEquipment(UpdateEquipmentRequest $request) {
        
        if ($request->fails()) 
            return $request->messages();    
        
        $request->equipment()->update();
        return $request->messages();
    }
}