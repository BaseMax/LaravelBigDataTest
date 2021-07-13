const DEFAULT_TITLE = "Laravel BigData Test";
const API_URL = "http://localhost:8000/api/";

const API = {
	LOGIN: () => {
		return API_URL+"login/";
	},
	USERS: () => {
		return API_URL+"users/";
	}
};

const getSid = () => {
	return localStorage.getItem("sid");
}

const getUid = () => {
	return localStorage.getItem("uid");
}

const alertDialog = (obj) => {
	if(obj && obj["alert"] && obj["alert"]["has"]) {
		if(obj["alert"]["has"] === 1) {
			alert(obj["alert"]["title"] + "\n" + obj["alert"]["message"]);
		}
	}
};

const request = (link, values=undefined, action) => {
	let req = values === undefined ? axios.get : axios.post
	const formData = new FormData();
	if(values !== undefined) {
		for(const key of Object.keys(values)) {
			formData.append(key, values[key]);
		}
	}
	req(link, formData, {
		headers: {
			// 'Content-Type': 'application/json',
			'Content-Type': 'multipart/form-data',
			'User-Sid': getSid(),
			'User-Uid': getUid(),
		}
	})
	.then((res) => {
		let obj = res.data;
		if(obj["status"] && (obj["status"] === "success" || obj["status"] === 1)) {
			alertDialog(obj);
			action(1, obj);
		}
		else {
			alertDialog(obj);
			action(0, obj);
		}
	})
	.catch((error) => {
		console.warn("error", error);
		action(-1, error);
	}).finally(() => {
		// Perform action in always
	});
};

const CheckAuth = () => {
	let sid = localStorage.getItem("sid");
	let uid = localStorage.getItem("uid");
	if(sid == null || sid == "" || sid == undefined || uid == null || uid == "" || uid == undefined) {
		return false;
	}
	return true;
};

const NotFoundComponent = {
	template: "#error-page",
	components: {},
	data: function() {
		return {

		};
	},
	mounted: function() {
		// this.$router.push("/");
	},
}

const LogoutPage = {
	mounted: function() {
		localStorage.removeItem("sid");
		localStorage.removeItem("uid");
		localStorage.clear();
		this.$router.push("/login/");
	},
};

const LoginPage = {
	template: "#login-page",
	components: {},
	data: function() {
		return {
			form: {
				email: "",
				password: "",
			},
		};
	},
	methods:{
		submitForm() {
			if(this.form.email === "" || this.form.password === "") {
				alert("Please fill your email and password!")
				return;
			}
			request(API.LOGIN, {
				email: this.form.email,
				password: this.form.password,
			}, (status, response) => {
				if(status === 1) {
					// save to localStorage
					localStorage.setItem("uid", response["uid"]);
					localStorage.setItem("sid", response["sid"]);
					this.$router.push("/");
				}
				// else if(status === 0) {}
			});
		}
	},
	mounted: function() {},
};

const HomePage = {
	template: "#home-page",
	components: {},
	data: function() {
		return {
			isLoaded: false,
			users: [],
		};
	},
	mounted: function() {
		if(!CheckAuth()) {
			this.$router.push("/login/");
		}
		axios.get(API.USERS, {
			headers: {
				'Content-Type': 'multipart/form-data',
				'User-Sid': getSid(),
				'User-Uid': getUid(),
			}
		})
		.then((res) => {
			console.log(res.data);
			let obj = res.data;
			console.log(obj);
			if(obj["status"] && obj["status"] === "success") {
				let users = obj["users"];
				console.log(users);
				this.users = users;
			}
		})
		.catch((error) => {
			alert("error" + error);
		}).finally(() => {
			this.isLoaded=true;
		});
	},
};

const routes = [
	{
		path: '/login/', component: LoginPage, meta: {
			// title: "",
		}
	},
	{
		path: '/logout/', component: LogoutPage, meta: {
		// title: "",
		}
	},
	{
		path: '/', component: HomePage, meta: {
			// title: "",
		}
	},
	{
		path: '/:pathMatch(.*)*', component: NotFoundComponent, meta: {
			title: "Error: 404 page!",
		}
	}
];

/*
 * Old version of vuejs, vuejs router
const router = new VueRouter({
	mode: "history",
	routes: routes,
})

const app = new Vue({
	el: "#app",
	router: router,
	components: {
	// footerbar: FooterBarComponent,
	},
	data: {},
	mounted: function() {
		// console.log(this.$router.currentRoute);
	},
});
*/

const router = VueRouter.createRouter({
	history: VueRouter.createWebHashHistory(),
	routes,
})

router.afterEach((to, from) => {
	Vue.nextTick(() => {
		document.title = to.title || to.meta.title || DEFAULT_TITLE;
	});
});

const app = Vue.createApp({})
app.use(router)
app.mount('#app')
