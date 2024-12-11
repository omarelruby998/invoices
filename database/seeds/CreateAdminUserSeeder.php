<?php
use Illuminate\Database\Seeder;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class CreateAdminUserSeeder extends Seeder
{
/**
* Run the database seeds.
*
* @return void
*/
public function run()
{

         $user = User::create([
        'name' => 'omarAhmed',
        'email' => 'admin@admin.com',
        'password' => bcrypt('12345677'),
        'roles_name' => ["owner"],
        'Status' => 'مفعل',
        ]);

//


}
}
