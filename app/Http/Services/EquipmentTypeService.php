<?php
namespace App\Http\Services;

use Illuminate\Http\Request;
use App\Models\EquipmentType;

/**
 * Сервис типов оборудования
 */
class EquipmentTypeService
{
     /**
     * Получить список типов оборудования с пагинацией и поиском
     *
     * @param Request    $request  принимает GET параметры per_page, name и q
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator Список типов оборудования с пагинацией
     */
    public function index(Request $request) 
    {
        $per_page = $request->get('per_page', 10);
        $name = $request->get('name', '') ?? '';
        $q = $request->get('q', '') ?? '';

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