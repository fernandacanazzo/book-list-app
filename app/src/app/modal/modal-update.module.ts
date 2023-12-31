import { NgModule } from '@angular/core';
import { NgForm } from '@angular/forms'
import { NgFormsModule } from '../ngforms.module';
import { ModalUpdateComponent } from './modal-update.component';

@NgModule({
  declarations: [
    ModalUpdateComponent
  ],
  imports: [
    NgFormsModule
  ],
  providers: [],
  bootstrap: [ModalUpdateComponent]
})

export class ModalUpdateModule { }
