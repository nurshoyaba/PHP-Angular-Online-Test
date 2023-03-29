import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders, HttpEvent } from '@angular/common/http';
import { Observable } from 'rxjs';



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

  getAllData()
  {
    let url = "http://localhost:8080/backend/index.php?getCSVdata=getall";
    return this.http.get(httpLink.getAllData + '?getCSVdata=getall');
  }

  
  public getDetailById(model: any): Observable<any> {
    return this.http.get(httpLink.getDetailById + '?Id=' + model);
  }

  public saveUser(model: any) {
   // return this.http.post(httpLink.saveUser1,model);
    const headers = new HttpHeaders().set('Content-Type', 'text/plain; charset=utf-8');
      return this.http.post(
        httpLink.saveUser1, 
        model, 
        { headers, responseType: 'json'}
      );
  } 

  public deleteUser(model: any){
      const headers = new HttpHeaders().set('Content-Type', 'text/plain; charset=utf-8');
     

      return this.http.post(httpLink.saveUser1,{"item_id":model}, { headers, responseType: 'json'});
  }

}
