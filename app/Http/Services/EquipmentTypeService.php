<?php
namespace App\Http\Services;

use App\Models\EquipmentType;
/**
 * Сервис типов оборудования
 */
class EquipmentTypeService
{
     /**
     * Получить список типов оборудования с пагинацией и поиском
     *
     * @param int    $per_page Число элементов на странице
     * @param string $name     Название типа оборудования
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator Список типов оборудования с пагинацией
     */
    public function index(int $per_page = 10, string $name = '') 
    {
        if (is_numeric($per_page) && $per_page <= 0)
            $per_page = 10;
        $query = EquipmentType::query();
        if ($name !== '')
            $query->where('name', 'LIKE', "%$name%");
        
        return $query->paginate($per_page);
    }
}