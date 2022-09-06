<?php

namespace App\Http\Controllers;
use App\Models\DBU as DB;
use App\Http\Requests\REQSTCAMP;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

// use Illuminate\Foundation\Auth\User;

class GeneralController extends Controller
{
    public function __construct(DB $db)
    {
        $this->db = $db;
    }

    public function home()
    {
        return view('index');
    }

    public function infokegiatan()
    {
        return view('general.infokegiatan');
    }

    public function register()
    {
        $count = $this->db->count();
        $IDS = array(
            'defid' => '20220100',
            'jumlah' => $count
        );
        return view('general.registrasi', $IDS);
    }

    public function login(Request $reqData){   
        $user = $this->db->where('email', '==', $reqData->email)->first();
        if($user){
            if(Hash::check($reqData->password, $user->password)){
                $reqData->session()->put('loginId', $user->id);
                return redirect()->route('dashboardaccount');
            } else{
                return redirect()->route('index');
            }
        } else{
            return redirect()->route('index');
        }
    }

    public function dashboardaccount()
    {
        $data = array();
        if (Session::has('loginId')) {
            $data = $this->db->where('email', '==', Session::get('loginId'))->first();
        }
        return view('general.dashboard', compact('data'));
    }

    public function logout(){
        if ($this->db::has('loginId')) {
            Session::pull('loginId');
            $msg = " Anda telah berhasil keluar dari keseluruhan aktivitas menu utama STCAMP404!!";
            return redirect()->route('index')->with('LogoutNotif', $msg);
        }
    }

    public function regUser(REQSTCAMP $reqData)
    {   
        $validated = $reqData->validated();
        if($validated){
            $this->db->create([
                'siswa_id' => $reqData->siswa_id,
                'name' => $reqData->name,
                'email' => $reqData->email,
                'password' => bcrypt($reqData->cpassword)
            ]);

            $msg = ' Selamat anda berhasil melakukan registrasi!!';
            return redirect()->route('registrasi')->with('registerNotif', $msg);
        }
    }

    public function forgetUser()
    {
        return view('general.forget');
    }

    public function resetUser(REQSTCAMP $reqData)
    {
        $validated = $reqData->validated();
        if ($validated) {
            // DBU::update([
            //     'siswa_id' => $reqData->siswa_id,
            //     'name' => $reqData->name,
            //     'email' => $reqData->email,
            //     'password' => bcrypt($reqData->cpassword)
            // ]);

            $msg = ' Selamat anda berhasil mereset password!!';
            return redirect()->route('forgetUser')->with('forgetNotif', $msg);
        }
    }
}
