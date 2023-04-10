import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders, HttpEvent } from '@angular/common/http';
import { Observable } from 'rxjs';
import { Products } from '../model/product';


// defining the base url of api and urls
var apiUrl = "http://localhost:8080/backend/";
var httpLink = {
    getAllData: apiUrl + "index.php",
    getDetailById: apiUrl + "index.php",
    saveUser1: apiUrl + "index.php",
}

@Injectable({
  providedIn: 'root'
})
export class UserService {
 
  constructor(private http: HttpClient) {
    
  }
  /*--------Get All Product list----------*/ 
  getAllData()
  {
    let url = "http://localhost:8080/backend/index.php?getCSVdata=getall";
    return this.http.get(httpLink.getAllData + '?getCSVdata=getall');
  }

  /*--------Get All Product by ID----------*/ 
  public getDetailById(model: number): Observable<any> {
    return this.http.get(httpLink.getDetailById + '?Id=' + model);
  }

  /*--------Save & Update Product----------*/ 
  public saveUser(model: Products) {
    const headers = new HttpHeaders().set('Content-Type', 'text/plain; charset=utf-8');
      return this.http.post(
        httpLink.saveUser1, 
        model, 
        { headers, responseType: 'json'}
      );
  } 
  /*--------Delete Product BY ID----------*/ 
  public deleteUser(model: any){
      const headers = new HttpHeaders().set('Content-Type', 'text/plain; charset=utf-8');
      return this.http.post(httpLink.saveUser1,{"item_id":model}, { headers, responseType: 'json'});
  }

}
