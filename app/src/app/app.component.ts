import { Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { HttpHeaders } from '@angular/common/http';
import { Book } from './book';
import { BooksService } from './services/books.service';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css'],
  providers: [BooksService]
})
export class AppComponent implements OnInit{
  books: any[] = [];

  constructor(private booksService: BooksService) {
  }

  ngOnInit(){
    this.booksService.getBooks().subscribe(
      (response) => {
        this.books = response;
      },(error) => {
        console.log(error);
      });
  }

}
