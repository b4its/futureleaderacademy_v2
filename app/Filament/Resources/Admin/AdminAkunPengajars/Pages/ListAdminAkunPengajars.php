<?php

namespace App\Filament\Resources\Admin\AdminAkunPengajars\Pages;

use App\Filament\Resources\Admin\AdminAkunPengajars\AdminAkunPengajarResource;
use App\Models\Profile;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ListAdminAkunPengajars extends ListRecords
{
    protected static string $resource = AdminAkunPengajarResource::class;
    protected static ?string $title = "Daftar Pengajar";

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Tambahkan Pengajar')
            ->modalHeading('Tambahkan Pengajar')
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
