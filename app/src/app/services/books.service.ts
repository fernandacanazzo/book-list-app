import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { Book } from '../interfaces/books.interface';

@Injectable({
  providedIn: 'root'
})
export class BooksService {

  private apiUrl = "http://localhost:8080";

  constructor(private http: HttpClient) { }

  getBooks() : Observable<Book[]>{

    return this.http.get<Book[]>(this.apiUrl + '/book/index');

  }

  deleteBook(bookId: any) : Observable<any[]>{
    
    //let options = { params: {id: 3} };
    return this.http.delete<any[]>(this.apiUrl + '/book/delete?id=' + bookId);

    //return this.http.get<Book[]>(this.apiUrl + '/book/index');

  }

}
