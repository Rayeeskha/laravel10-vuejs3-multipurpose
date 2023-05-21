<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <meta name="description" content="POS - Bootstrap Admin Template">
      <meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern,  html5, responsive">
      <meta name="author" content="Dreamguys - Bootstrap Admin Template">
      <meta name="robots" content="noindex, nofollow">
      <title>Vue & Laravel Multipurpose Application </title>
      <link rel="shortcut icon" type="image/x-icon" href="{{  asset('backend/assets/img/favicon.png') }}">
      <link rel="stylesheet" href="{{ asset('backend/assets/css/bootstrap.min.css') }}">
      <link rel="stylesheet" href="{{ asset('backend/assets/css/animate.css') }}">
      <link rel="stylesheet" href="{{ asset('backend/assets/plugins/select2/css/select2.min.css') }}">
      <link rel="stylesheet" href="{{ asset('backend/assets/css/dataTables.bootstrap4.min.css') }}">
      <link rel="stylesheet" href="{{  asset('backend/assets/plugins/fontawesome/css/fontawesome.min.css') }}">
      <link rel="stylesheet" href="{{ asset('backend/assets/plugins/fontawesome/css/all.min.css') }}">
      <link rel="stylesheet" href="{{ asset('backend/assets/css/style.css') }}">

      @vite('resources/css/app.css')
   </head>