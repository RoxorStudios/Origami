<!DOCTYPE html>

<html lang="en">
<head>
	<meta charset="utf-8">

	<title>Origami</title>
	<meta name="description" content="The HTML5 Herald">
	<meta name="author" content="SitePoint">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<meta name="csrf_token" content="{{ csrf_token() }}">
	
	<link rel="stylesheet" href="{{ asset('vendor/origami/css/origami.css') }}">
	<link rel="stylesheet" href="{{ asset('vendor/origami/css/grid.css') }}">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">


  	<!--[if lt IE 9]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
    <![endif]-->
</head>
<body>
	@include('origami::layouts.partials.icons')