<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    <div id="vue-app" class="card" style="width:30%;left:35%;margin-top:100px;border:1px solid">
        <div class="card-body shadow-none p-3 mb-5 bg-light rounded">
            <h5 class="card-title">
                <center>
                    Login
                </center>
            </h5>
            <!-- <form> -->
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email address</label>
                <input v-model="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input v-model="password" type="password" class="form-control" id="exampleInputPassword1">
            </div>
            <button class="btn btn-primary" @click="doLogin">Masuk</button>
            <!-- </form> -->
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        var vm = new Vue({
            el: '#vue-app',
            data: {
                email: '',
                password: ''
            },
            methods: {
                doLogin() {

            $.ajax({
            url:"/api/auth/login",
            method:"post",
            data:{
                email : this.email,
                password : this.password,
            },
            success:function(res){
                setTimeout(() => {
                window.location.href = "http://127.0.0.1:8000/beranda";
                localStorage.setItem('user', JSON.stringify(response.data.data))
                localStorage.setItem('token', JSON.stringify(response.data.token))
                localStorage.setItem('LoggedUser', true)
                }, 500);
            },
        })
                    // console.log('email', this.email)
                    // console.log('password', this.password)
                    // axios.post('/api/auth/login', {
                    //         email: this.email,
                    //         password: this.password
                    //     })
                    //     .then(function(response) {
                    //         setTimeout(() => {
                    //             window.location.href = "http://127.0.0.1:8000/beranda";
                    //             localStorage.setItem('user', JSON.stringify(response.data.data))
                    //             localStorage.setItem('token', JSON.stringify(response.data.token))
                    //             localStorage.setItem('LoggedUser', true)
                    //         }, 500);
                    //     })
                    //     .catch(function(error) {
                    //         console.log(error);
                    //     });



                }
            }
        });
    </script>
</body>

</html>
