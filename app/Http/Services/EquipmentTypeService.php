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
     * @param string $q        Поиск по нескольким столбцам
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator Список типов оборудования с пагинацией
     */
    public function index(int $per_page = 10, string $name = '', string $q = '') 
    {
        if (is_numeric($per_page) && $per_page <= 0)
            $per_page = 10;
        
        $query = EquipmentType::query();

        if ($q !== '')
            return $query
                ->where('name', 'LIKE', "%$q%")
                ->orWhere('mask', 'LIKE', "%$q%")
                ->paginate($per_page);

        if ($name !== '')
            $query->where('name', 'LIKE', "%$name%");
        
        return $query->paginate($per_page);
    }
}