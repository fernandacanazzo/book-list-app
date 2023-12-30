import { Component } from '@angular/core';
import { MdbModalRef } from 'mdb-angular-ui-kit/modal';
import { BooksService } from '../services/books.service';

@Component({
  selector: 'app-modal',
  templateUrl: './modal-delete.component.html',
})
export class ModalComponent {

  id: string | null = null;
  deletedBook: any | null = null;

  constructor(private booksService: BooksService, public modalRef: MdbModalRef<ModalComponent>) {}

  deleteBook(bookId: any){

    //this.deletedBook = this.booksService.deleteBook();

    this.booksService.deleteBook(bookId).subscribe({
      next: (response: any[]) => {
       // this.deletedBook = response;
        console.log(response);
      }, error: (error) => {
        console.log(error);
      }
    });

  }


}