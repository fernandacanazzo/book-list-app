import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})

export class LoginService {

  private apiUrl = "http://localhost:8080";

  constructor(private http: HttpClient) { }

  login(login: any) : Observable<any[]>{
    
    let headers = new HttpHeaders({
    'Content-Type': 'text/plain'});
    let options = { headers: headers };
    
    return this.http.post<any[]>(this.apiUrl + '/auth/create', {
      username: login.username, 
      password: login.password
    });

  }

}
