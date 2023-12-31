import { Component } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Router } from '@angular/router';
import { LoginService } from '../../services/login.service';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent {

  inputLogin: any = {

    username: "",
    password: ""

  };

  errorMsg: any = null;

  constructor(private LoginService: LoginService, private router: Router) {
  }

  login(login: any){

    this.LoginService.login(login).subscribe({
      next: (response: any) => {

          localStorage.setItem('token', response.token);
          this.router.navigateByUrl('/'); 

      }, error: (error) => {

        this.errorMsg = error.error.message;
        console.log(error); 

      },
    });

  }

}
