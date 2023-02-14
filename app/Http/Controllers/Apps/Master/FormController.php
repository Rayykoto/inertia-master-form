<?php

namespace App\Http\Controllers\Apps\Master;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Models\master_table_structure;
use Spatie\Permission\Models\Permission;

class FormController extends Controller
{
   public function index()
    {
        $a = array();
        if(auth()){
            $user_id = auth()->user()->id;
        }
        $user = User::where('id',$user_id)->first();
        $sides = Role::where('name', $user->getRoleNames())->with('permissions')->latest()->get();
        $e = '(';
        for ($i = 0; $i < $sides->count(); $i++){
            for ($j = 0; $j < $sides[$i]['permissions']->count(); $j++){
                if(str_contains($sides[$i]['permissions'][$j]['name'], 'index')){
                    if(str_contains($sides[$i]['permissions'][$j]['name'],'form')){
                        $a[] = array(explode('-', explode('.', $sides[$i]['permissions'][$j]['name'])[0])[1]);
                        $e .= "'".explode('-', explode('.', $sides[$i]['permissions'][$j]['name'])[0])[1]."',";
                        $b[]= explode('-', explode('.', $sides[$i]['permissions'][$j]['name'])[0])[1];
                    }
                }
            }
        }
        $select_val = substr($e,0,-1);
        $select_val .= ')';
        $form_access = DB::table('master_tables')->whereIn('name',$a)->get();

        return Inertia::render('Apps/Forms/Index', [
            'form_access'   => $form_access,
        ]);
    }

    public function create()
    {
        $roles = Role::all();
        return Inertia::render('Apps/Forms/Create', [
            'roles' => $roles,
        ]);
    }

    public function create_form(Request $request)
    {
        $user_id = auth()->user()->id;
        $table_name     = str_replace(' ','',strtolower($request->name));
        $index          = 'form-'.$table_name.'.index';
        $create         = 'form-'.$table_name.'.create';
        $edit           = 'form-'.$table_name.'.edit';
        $delete         = 'form-'.$table_name.'.delete';
        $group_name     = "Admin";
        $query          = "CREATE TABLE $table_name (id int(11) NOT NULL AUTO_INCREMENT, created_at timestamp(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP, updated_at timestamp(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
         created_by int(11), updated_by int(11), status varchar(1) NOT NULL, PRIMARY KEY (`id`) USING BTREE)";

        DB::statement($query);

        DB::insert("INSERT INTO master_tables (`group`, `name`, `description`,`is_show`,`created_by`,`updated_by`) VALUES ('Admin','$table_name','$request->name','1','$user_id','$user_id')");

        $input_index    = Permission::create(['name' => $index,   'guard_name' => 'web']);
        $input_create   = Permission::create(['name' => $create,  'guard_name' => 'web']);
        $input_edit     = Permission::create(['name' => $edit,    'guard_name' => 'web']);
        $create_delete  = Permission::create(['name' => $delete,  'guard_name' => 'web']);

        for($i = 0; $i < count($request->roles); $i++){
            $role_data = Role::where('name',$request->roles[$i])->first();
            // RoleHasPermission::create(['permission_id'=>$input_index->id , 'role_id'=>$role_data->id]);
            DB::table('role_has_permissions')->insert(['permission_id'=>$input_index->id , 'role_id'=>$role_data->id]);
        }

        return redirect()->route('apps.master.forms.index');
    }

    public function show(Request $request, $name)
    {
        $request_name = request()->segment(count(request()->segments()));
        $a = '';
        if(auth()){
            $user_id = auth()->user()->id;
        }
        $user = User::where('id',$user_id)->first();
        $permissions = $user->getPermissionsViaRoles();
        if($request_name == 'manage'){
            $role_request = 'manage';
        } else {
            if($request_name == 'add_data'){
                $role_request = 'create';
            } else {
                $role_request = 'index';
            }
            for ($j = 0; $j < $permissions->count(); $j++){
                if(str_contains($permissions[$j]['name'], $role_request)){
                    $a .= $permissions[$j]['name'].', ';
                }
            }
        }
        $select_field = '';$form = ''; $relate = ''; $result = '';$table_to_check = [];$parent = [];$child = [];
        $select = DB::table('master_tables')->where('name',$name)->first();
        $table_name = $select->description;
        $title  = DB::table('master_table_structures')->where('table_id',$select->id)->where('is_show',1)->get();
        $relation = DB::table('master_relation')->where('table_name_from',$name)->get();
        $header = DB::table('master_table_structures')->where('table_id',$select->id)->where('is_show',1)->get();
        if ($title->count() > 0){
			foreach ($title as $index => $t){
				$select_field .= 'id,'.$t->field_name.',';
                if($t->relate_to != ''){
                    if(str_contains($t->input_type, 'Child')){
                        $relations = $t->relate_to;
                        $relate_table = explode('#',$relations);
                        $field_check = $relate_table[1];
                        $check_data = DB::table($relate_table[0])->get();
                        foreach ($check_data as $chk_data){
                            $child[$t->input_type][$field_check] = $check_data;
                        }
                    } else if (str_contains($t->input_type, 'Parent')){
                        $relations = $t->relate_to;
                        $relate_table = explode('#',$relations);
                        $field_check = $relate_table[1];
                        $check_data = DB::table($relate_table[0])->distinct()->get([$field_check]);
                        foreach ($check_data as $chk_data){
                            $parent[$t->input_type][$field_check] = $check_data;
                        }
                    } else {
                        $relations = $t->relate_to;
                        $relate_table = explode('#',$relations);
                        $field_check = $relate_table[1];
                        $check_data = DB::table($relate_table[0])->get([$field_check]);
                        foreach ($check_data as $chk_data){
                            $table_to_check[$t->input_type][$field_check] = $check_data;
                        }
                    }
                }
			}
			$selected = substr($select_field, 0,-1);
            if(str_contains(strtolower($user->getRoleNames()), 'staff')){
                $form = DB::table($name)->selectRaw($selected)->where('created_by',$user_id)->where('status','1')->get();
            } else {
                $form = DB::table($name)->selectRaw($selected)->where('status','1')->get();
            }
		} else {
            $form = DB::table($name)->latest()->get();
        }
        // $table_name_to = array();
        $result = array();
        if($relation->count() > 0){
            foreach ($relation as $rel){
                    $result[] = [$rel->field_from => DB::table($rel->table_name_to)->get(),"field_from" => $rel->field_from];
            }$relate = 'yes';
        } else {
            $relate = 'no';
        }
        // dd($name);
        $field  = DB::table('master_datatype')->get();
        $show_table  = DB::table('master_tables')->where('is_show',1)->where('group',$select->group)->get();
        // dd($request_name);
        if($role_request == 'manage'){
            return Inertia::render('Apps/Forms/Manage/Manage', [
                'group'         => DB::table('master_tablegroup')->get(),
                'table'         => $name,
                'create_data'   => 'form-'.$name.'.create',
                'edit_data'     => 'form-'.$name.'.edit',
                'delete_data'   => 'form-'.$name.'.delete',
                'table_name'    => $table_name,
                'title'         => $title,
                'fields'        => $field,
                'headers'       => $header,
                'forms'         => $form,
                'checklist'     => $table_to_check,
                'child'         => $child,
                'parent'        => $parent,
                'show_table'    => $show_table,
                'relation'      => $relation,
                'related'       => $result,
                'relate'        => $relate,
            ]);
        }else {
            if(str_contains($a, $name)){
                switch($request_name){
                    case 'show':
                        return Inertia::render('Apps/Forms/Show', [
                            'group'         => DB::table('master_tablegroup')->get(),
                            'table'         => $name,
                            'create_data'   => 'form-'.$name.'.create',
                            'edit_data'     => 'form-'.$name.'.edit',
                            'delete_data'   => 'form-'.$name.'.delete',
                            'table_name'    => $table_name,
                            'title'         => $title,
                            'fields'        => $field,
                            'headers'       => $header,
                            'forms'         => $form,
                            'checklist'     => $table_to_check,
                            'child'         => $child,
                            'parent'        => $parent,
                            'show_table'    => $show_table,
                            'relation'      => $relation,
                            'related'       => $result,
                            'relate'        => $relate,
                        ]);
                        break;
                    case 'add_data' :
                        return Inertia::render('Apps/Forms/Show', [
                            'group'         => DB::table('master_tablegroup')->get(),
                            'table'         => $name,
                            'create_data'   => 'form-'.$name.'.create',
                            'edit_data'     => 'form-'.$name.'.edit',
                            'delete_data'   => 'form-'.$name.'.delete',
                            'table_name'    => $table_name,
                            'title'         => $title,
                            'fields'        => $field,
                            'headers'       => $header,
                            'forms'         => $form,
                            'checklist'     => $table_to_check,
                            'child'         => $child,
                            'parent'        => $parent,
                            'show_table'    => $show_table,
                            'relation'      => $relation,
                            'related'       => $result,
                            'relate'        => $relate,
                        ]);
                        break;
                }
            }
            return Inertia::render('Apps/Forbidden', [
            ]);
        }
    }

    public function create_data(Request $request){
        $table          = $request->table;
        $select         = DB::table('master_tables')->where('name',$request->table)->first();
        $table_head     = DB::table('master_table_structures')->where('table_id',$select->id)->where('is_show',1)->get();

        $now            = Carbon::now()->toDateTimeString();
        $auth           = auth()->user()->id;
		$select_field	= 'created_at,updated_at,created_by,updated_by,status,';
		$values	        = '"'.$now.'","'.$now.'",'.$auth.','.$auth.',"1",';

        foreach ($table_head as $t){
            $fields = $t->field_name;
            $select_field .= $t->field_name.',';
            if($t->input_type == 'File'){
                $file= $request->file($fields)->store($table.'-'.$fields);
                $values .= "'".$file."',";
            } else if($t->input_type == 'Checklist'){
                if($request->$fields == ''){
                    $values .= "NULL,";
                } else {
                    $vehicleString = implode(",", $request->$fields);
                    $values .= "'".$vehicleString."',";
                }
            } else {
                $values .= "'".$request->$fields."',";
            }
        }
        $selected = substr($select_field, 0,-1);
        $insert_value = substr($values, 0,-1);

		$insert = DB::statement("INSERT INTO $table ($selected) VALUES ($insert_value);");
		if($insert){
			return redirect()->route('apps.master.forms.show',$table);
		}
    }

    public function update_data(Request $request){
        $table			= $request->table;
		$edit_id		= $request->data_id;
        $select         = DB::table('master_tables')->where('name',$request->table)->first();
        $table_head     = DB::table('master_table_structures')->where('table_id',$select->id)->where('is_show',1)->get();
		$select_field	= '';
		$values	        = '';
		if (count($table_head) > 0){
			foreach ($table_head as $t){
                $fields = $t->field_name;
				if($t->input_type == 'File'){
                    if($request->file($fields)){
                        $file= $request->file($fields)->store($table.'-'.$fields);
                        $values .= $t->field_name."='".$file."',";
                    }
                } else if($t->input_type == 'Checklist'){
                    if($request->$fields == ''){
                        $values .= $t->field_name."=NULL,";
                    } else {
                        $vehicleString = implode(",", $request->$fields);
                        $values .= $t->field_name."='".$vehicleString."',";
                    }
                } else {
                    $values .= $t->field_name."='".$request->$fields."',";
                }
			}
			$selected = substr($values, 0,-1);
		}
		$insert = DB::statement("UPDATE $table SET $selected WHERE id='$edit_id';");
		if($insert){
			return redirect()->route('apps.master.forms.show',$table);
		}
    }
    
    public function add_column(Request $request){
        if($request->data_type == 'Checklist'){
            $relate_to = $request->table_to.'#'.$request->field_to;
        } else { $relate_to = ''; }
        $field_name = str_replace(' ', '',strtolower($request->name));
        $table_name = $request->table;
        $data_type      = DB::table('master_datatype')->where('name',$request->data_type)->first();
        $table_selected = DB::table('master_tables')->where('name',$table_name)->first();

        $structure = new master_table_structure;
        $structure->table_id            = $table_selected->id;
        $structure->field_name          = $field_name;
        $structure->field_description   = $request->name;
        $structure->is_show             = '1';
        $structure->data_type           = $data_type->data_type;
        $structure->field_name          = $field_name;
        $structure->relation            = '0';
        $structure->input_type          = $request->data_type;
        $structure->relate_to           = $relate_to;
        $structure->created_by          = auth()->user()->id;
        $structure->save();


        $query = "ALTER TABLE `$table_name` ADD `$field_name` $data_type->data_type";
        //dd($query);
		//DB::insert("INSERT INTO $description (field_name,field_description,is_show,data_type,relation,input_type,relate_to) VALUES ('$field_name','$request->name','1','$data_type->data_type','0','$request->data_type','$relate_to')");

        DB::statement($query);

        return redirect()->route('apps.master.forms.show',$table_name);
    }

    public function delete_data($name,$id){
        // dd($name,$id);
		$table_head		= DB::statement("DELETE FROM $name WHERE id='$id';");
		$table_head		= DB::statement("UPDATE $name SET status='0' WHERE id='$id';");
        if($table_head){
            return redirect()->route('apps.master.forms.show',$name);
        }
	}
}
