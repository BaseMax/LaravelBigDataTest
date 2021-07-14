<!DOCTYPE html>
<html>
<head>
	<title>Laravel BigData Test</title>
	<meta charset="utf-8">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>
<body>

	<div class="container-fluid" id="app">
		<div>
			<router-view :key="$route.fullPath"></router-view>
		</div>
	</div>

	<template id="error-page">
		<div class="container">
			<div>
				<center>
					<br><br><br><br><br>
					<h2>Error 404!</h2>
					<p>Sorry, We unable to find your page and answer your request!</p>
					<br>
					<router-link :to="'/'">Go back to home page</router-link>
					<br><br>
				</center>
			</div>
		</div>
	</template>

	<template id="login-page">
		<div class="container">
			<div class="row">
				<div class="col-md-4"></div>
				<div class="col-md-4">
					<br>
					<h2>Login page</h2>
					<br>
					<form v-on:submit.prevent="submitForm">
						<div class="form-group">
							<label for="exampleInputEmail1">Email address</label>
							<input type="text" name="email" class="form-control" placeholder="email" v-model="form.email" class="form-control">
							<small class="form-text text-muted">We'll never share your email with anyone else.</small>
						</div>
						<div class="form-group">
							<label for="exampleInputEmail1">Password</label>
							<input type="password" name="password" class="form-control" placeholder="password" v-model="form.password" class="form-control">
						</div>
						<br>
						<button style="margin-bottom: 10px;background: #d1e7dd;color: #736e6e;border: 1px solid #afb5b2;" type="submit" class="btn btn-primary">Submit</button>
					</form>
				</div>
				<div class="col-md-4"></div>
			</div>
		</div>
	</template>

	<template id="home-page">
		<div class="container">
			<br>
			Hey Admin, Welcome to <i>Dashboard</i>. <button type="button" v-on:click="logout" class="btn btn-dark float-end">Logout</button>
			<br><br>
			<h1>
				<svg width="45" height="45" viewBox="0 0 47 47"><g transform="translate(-1180 -1843.044)"><path d="M34,42.727H10a10,10,0,0,1-10-10v-15.8c0-5.523,3.8-8.2,7-9.8L26.6.727c11.6-3.2,17.4,4.716,17.4,13v19A10,10,0,0,1,34,42.727Z" transform="translate(1183 1843.044)" fill="#d1e7dd"></path> <g transform="translate(183 -778.956)"><g transform="translate(997 2629)"><path d="M22.459,0a3.6,3.6,0,0,0-.8,7.112V13.2a.8.8,0,1,0,1.6,0V7.112A3.6,3.6,0,0,0,22.459,0Zm0,5.6a2,2,0,1,1,2-2A2,2,0,0,1,22.459,5.6Z" transform="translate(-2.459 0)" fill="#0b032d"></path> <path d="M36.88,10.58H22.4a.8.8,0,0,0,0,1.6H36.88A1.52,1.52,0,0,1,38.4,13.7V31.78H33.672A3.272,3.272,0,0,0,30.4,35.052V39.78H3.12A1.52,1.52,0,0,1,1.6,38.26V13.7a1.52,1.52,0,0,1,1.52-1.52H17.6a.8.8,0,0,0,0-1.6H3.12A3.12,3.12,0,0,0,0,13.7V38.26a3.12,3.12,0,0,0,3.12,3.12H31.2a.8.8,0,0,0,.564-.236l1.364-1.364L38.4,34.508l1.364-1.364A.8.8,0,0,0,40,32.58V13.7a3.12,3.12,0,0,0-3.12-3.12ZM32,38.652v-3.6a1.672,1.672,0,0,1,1.672-1.672h3.6Z" transform="translate(0 -1.38)" fill="#0b032d"></path> <rect width="28.8" height="1.6" rx="0.8" transform="translate(5.6 17.2)" fill="#0b032d"></rect> <rect width="28.8" height="1.6" rx="0.8" transform="translate(5.6 22)" fill="#0b032d"></rect> <rect width="28.8" height="1.6" rx="0.8" transform="translate(5.6 26.8)" fill="#0b032d"></rect></g></g></g></svg>
				Users
			</h1>
			<br>
			<p>
				What is Lorem Ipsum Lorem Ipsum is simply dummy text of the printing and typesetting industry Lorem Ipsum has been the industry's standard dummy text ever since the 1500s when an unknown printer took a galley of type and scrambled it to make a type specimen book it has?
			</p>
			<br>
			<div v-if="!isLoaded" style="text-align:center;">
				<br><br>
				Please wait...
				<br><br>
			</div>
			<table v-if="isLoaded" class="table table-success table-striped">
				<thead>
					<tr>
						<th scope="col">#</th>
						<th scope="col">Name</th>
						<th scope="col">Email</th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="(item, index) in users" :key="index">
						<th scope="row">@{{index+1}}</th>
						<td>@{{item.name}}</td>
						<td>@{{item.email}}</td>
					</tr>
				</tbody>
			</table>
			<br><br>
		</div>
	</template>

	<script type="text/javascript" src="https://cdn.jsdelivr.net/combine/npm/vue@next,npm/vue-router@next,npm/axios@next"></script>
	<script type="text/javascript" src="/script.js"></script>
</body>
</html>
