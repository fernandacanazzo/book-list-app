import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs';
import { Book } from '../interfaces/books.interface';

@Injectable({
  providedIn: 'root'
})
export class BooksService {

  private apiUrl = "http://localhost:8080";

  constructor(private http: HttpClient) { }

  getBooks() : Observable<any[]>{

    return this.http.get<any[]>(this.apiUrl + '/book/index');

  }

  deleteBook(bookId: any) : Observable<any[]>{
    
    return this.http.delete<any[]>(this.apiUrl + '/book/delete?id=' + bookId);

  }

  insertBook(title: string, description: string, author: string, number_of_pages: number) : Observable<any[]>{ 

    let headers = new HttpHeaders({
    'Content-Type': 'text/plain'});
    let options = { headers: headers };

    return this.http.post<any[]>(this.apiUrl + '/book/create', {
      title: title, 
      description: description, 
      author: author, 
      number_of_pages: number_of_pages
    }, options);

  }

  updateBook(book: Book) : Observable<any[]>{

    let headers = new HttpHeaders({
    'Content-Type': 'text/plain'});
    let options = { headers: headers };
    
    return this.http.patch<any[]>(this.apiUrl + '/book/update?id=' + book.id, {
      title: book.title,
      description: book.description,
      author: book.author,
      number_of_pages: book.number_of_pages
    }, options);

  }

}
