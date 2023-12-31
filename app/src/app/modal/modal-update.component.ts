import { Component } from '@angular/core';
import { MdbModalRef } from 'mdb-angular-ui-kit/modal';
import { BooksService } from '../services/books.service';
import { Book } from '../interfaces/books.interface';

@Component({
  selector: 'app-modal-update',
  templateUrl: './modal-update.component.html',
})
export class ModalUpdateComponent {

  title: any;
  description: any;
  author: any;
  number_of_pages: any;

  book: Book = {
    id: 1,
    title: '',
    description: '',
    author: '',
    number_of_pages: 1
  }

  constructor(private booksService: BooksService, public modalUpdateRef: MdbModalRef<ModalUpdateComponent>) {}

  updateBook(book: Book){

   this.booksService.updateBook(book).subscribe({
      next: (response: any[]) => {
       
        this.modalUpdateRef.close(response);

      }, error: (error) => {

        this.modalUpdateRef.close(error);

      }
    });

  }

}