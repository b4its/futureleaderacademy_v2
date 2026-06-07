<?php

namespace App\Filament\Resources\Admin\AdminAkunMembers\Pages;

use App\Filament\Resources\Admin\AdminAkunMembers\AdminAkunMemberResource;
use App\Models\Profile;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ListAdminAkunMembers extends ListRecords
{
    protected static string $resource = AdminAkunMemberResource::class;
    protected static ?string $title = "Daftar Member";

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Tambahkan Member')
            ->modalHeading('Tambahkan Member')
            ->mutateFormDataUsing(function (array $data): array {
                    $data['role'] = "pengajar";
                    return $data;
             })
             ->using(function (array $data, string $model): Model {
                    return DB::transaction(function () use ($data) {

                        // LANGKAH 1: Buat Keranjang sebagai wadah
                        $profile = Profile::updateOrCreate(
                            ['user_id' => $data['user_id']], // Kondisi pencarian
                            [                                // Data yang di-update atau di-create
                                'kelas_id' => $data['kelas_id'] ?? null,
                                'first_name' => $data['first_name'] ?? null,
                                'last_name' => $data['last_name'] ?? null,
                            ]
                        );


                    

                        

                        return $profile;
                    });
                }),
            
        ];
    }
}
