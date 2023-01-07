<?php

namespace App\Imports;

use App\Models\File;
use App\Models\Post;
use App\Models\Company;
use App\Models\Language;
use App\Enums\FileTypeEnum;
use App\Enums\PostStatusEnum;
use Maatwebsite\Excel\Concerns\ToArray;

class PostsImport implements ToArray
{
    public function array(array $array): void
    {
        dd($array);
        foreach ($array as $each) {
            try {
                $companyName = $each['cong_ty'];
                $language    = $each['ngon_ngu'];
                $city        = $each['dia_diem'];
                $link        = $each['link'];

                if (!empty($companyName)) {
                    $companyId = Company::firstOrCreate([
                        'name' => $companyName,
                    ], [
                        'city'    => $city,
                        'country' => 'Vietnam',
                    ])->id;
                } else {
                    $companyId = null;
                }


                $post = Post::create([
                    'job_title'  => $language,
                    'company_id' => $companyId,
                    'city'       => $city,
                    'status'     => PostStatusEnum::ADMIN_APPROVED,
                ]);

                $languages = explode(',', $language);
                foreach ($languages as $language) {
                    Language::firstOrCreate([
                        'name' => trim($language),
                    ]);
                }

                File::create([
                    'post_id' => $post->id,
                    'link'    => $link,
                    'type'    => FileTypeEnum::JD,
                ]);
            } catch (\Throwable $e) {
                dd($each);
            }
        }
    }
}
