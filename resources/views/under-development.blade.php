<x-dashboard-layout>
    <x-slot name="head_tags">
        <style>
            div.dataTables_wrapper div.dataTables_length label select {
                min-width: 60px;
            }
        </style>
    </x-slot>

    <x-slot name="pageTitle">Under Development</x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Under development</li>
    </x-slot>

    <div class="alert alert-info mx-auto" style="width: max-content; max-width: 640px;">
        <strong>Under Development!</strong> This page is currently under development.
    </div>
</x-dashboard-layout>
