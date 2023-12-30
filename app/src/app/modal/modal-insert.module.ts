import { NgModule } from '@angular/core';
import { NgForm } from '@angular/forms'
import { NgFormsModule } from '../ngforms.module';
import { ModalInsertComponent } from './modal-insert.component';

@NgModule({
  declarations: [
    ModalInsertComponent
  ],
  imports: [
    NgFormsModule
  ],
  providers: [],
  bootstrap: [ModalInsertComponent]
})

export class ModalInsertModule { }
