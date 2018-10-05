<?php

namespace App\Http\Controllers;

use Auth;
use App\QRCode;
use App\User;
use Illuminate\Http\Request;
use LaravelQRCode\Facades\QRCode as QRCodeRenderer;

class QRCodeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        return Auth::user()->codes;
    }

    public function tempCode()
    {
        return QRCodeRenderer::text('Test link')->svg();
    }

    public function new()
    {
        $codeData = request()->validate([
            'name'      => 'required',
            'redirect'  => 'required'
        ]);
        $codeData['link'] = str_random(5);
        return Auth::user()->codes()->create($codeData);
    }

    public function update(QRCode $code) {
        $this->authorize('update', $code);
        $code->update(request()->all());
        return $code;
    }

    public function delete(QRCode $code) {
        $this->authorize('update', $code);
        $code->delete();
        return $code;
    }
}