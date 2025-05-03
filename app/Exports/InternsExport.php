<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Http\Request;

class InternsExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $request;
    
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = User::query()->where('role_id', 3);
        
        if ($this->request->filled('first_name')) {
            $query->where('first_name', 'like', '%' . $this->request->first_name . '%');
        }
        
        if ($this->request->filled('last_name')) {
            $query->where('last_name', 'like', '%' . $this->request->last_name . '%');
        }
        
        if ($this->request->filled('email')) {
            $query->where('email', 'like', '%' . $this->request->email . '%');
        }
        
        // Apply sorting from request if available
        $sort = $this->request->input('sort', 'id');
        $direction = $this->request->input('direction', 'desc');
        
        return $query->orderBy($sort, $direction)->get();
    }
    
    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'First Name',
            'Last Name',
            'Email',
            'Status',
            'Assigned Mentor',
            'Created At',
            'Updated At'
        ];
    }
    
    /**
     * @param User $intern
     * @return array
     */
    public function map($intern): array
    {
        // Get mentor name if available
        $mentorName = '';
        if ($intern->assigned_mentor_id) {
            $mentor = User::find($intern->assigned_mentor_id);
            if ($mentor) {
                $mentorName = $mentor->first_name . ' ' . $mentor->last_name;
            }
        }
        
        return [
            $intern->id,
            $intern->first_name,
            $intern->last_name,
            $intern->email,
            $intern->status ?? 'N/A',
            $mentorName,
            $intern->created_at->format('Y-m-d H:i:s'),
            $intern->updated_at->format('Y-m-d H:i:s')
        ];
    }
    
    /**
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as headers
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '199254']  // Match the primary color
                ],
            ],
        ];
    }
}