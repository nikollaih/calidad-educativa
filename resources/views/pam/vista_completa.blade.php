@extends('layouts.app_empty')

    <div
        data-component="PamVistaCompleta"
        data-csrf-token="{{ csrf_token() }}"
    ></div>
    
    @vite('resources/js/app.js')