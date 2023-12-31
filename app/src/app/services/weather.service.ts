import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})

export class WeatherService {

  private apiUrl = "http://localhost:8080";

  constructor(private http: HttpClient) { }

  getWeather() : Observable<any[]>{

    let headers = new HttpHeaders({
    'Content-Type': 'text/plain'});
    let options = { headers: headers };
    
    return this.http.get<any[]>(this.apiUrl + '/weather');

  }

}
