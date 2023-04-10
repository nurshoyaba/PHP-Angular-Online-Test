import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { Routes, RouterModule } from '@angular/router';
import { HttpClientModule } from '@angular/common/http';
import { FormsModule,ReactiveFormsModule } from '@angular/forms';

import { AppRoutingModule } from './app-routing.module';

import { AppComponent } from './app.component';
import { DashboardComponent } from './dashboard/dashboard.component';
import { AddUserComponent } from './add-user/add-user.component';
import { EditUserComponent } from './edit-user/edit-user.component';
import { AgGridModule } from 'ag-grid-angular';
import { CellCustomeComponent } from './cell-custome/cell-custome.component';

const routes: Routes = [
  { path: '', redirectTo: 'Home', pathMatch: 'full'},
  { path: 'Home', component: DashboardComponent },
  { path: 'AddUser', component: AddUserComponent },
  { path: 'EditUser/:item_id', component: EditUserComponent }

];
@NgModule({
  declarations: [
    AppComponent,
    DashboardComponent,
    AddUserComponent,
    EditUserComponent,
    CellCustomeComponent

  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    RouterModule.forRoot(routes),
    AppRoutingModule,
    HttpClientModule,
    FormsModule,
    ReactiveFormsModule,
    AgGridModule,
    AgGridModule,      
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
