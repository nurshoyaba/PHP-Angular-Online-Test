import { ComponentFixture, TestBed } from '@angular/core/testing';

import { CellCustomeComponent } from './cell-custome.component';

describe('CellCustomeComponent', () => {
  let component: CellCustomeComponent;
  let fixture: ComponentFixture<CellCustomeComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ CellCustomeComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(CellCustomeComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
