use Illuminate\Http\Request;
use App\Models\Employee;

use App\Services\EmployeeService;

use Exception;


class EmployeeController extends Controller
{
    public function store(Request $request)
    public function destroy(Employee $employee)
    {
        try {
            // Melakukan penghapusan (akan menjadi Soft Delete jika model mendukung)
            
            $employee->delete();

            return response()->json([
            ], 500);
        }
    }
}

    public function update(Request $request, $id)
{
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:employees,email,' . $id,
            'phone_number' => 'required|string',
            'place_of_birth' => 'required|string',
            'date_of_birth' => 'required|date',
            'address' => 'required|string',
            'id_number' => 'required|string',
            'role_id' => 'required|integer',
    ]);

    $employeeService = new EmployeeService();
    $employee = $employeeService->updateEmployee($id, $validated);

    if (!$employee) {
        return response()->json([
            'payload' => [
                'statusCode' => 404,
                'message' => 'Employee not found',
                'data' => null
            ]
        ], 404);
    }

    return response()->json([
        'payload' => [
            'statusCode' => 200,
            'message' => 'Employee updated successfully!',
            'data' => $employee
            ]
        ], 200);
    }
}