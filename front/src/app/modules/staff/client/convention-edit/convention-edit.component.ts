import { Component, Input, OnInit } from '@angular/core';
import { Convention } from '../../../../core/classes/models/convention';
import { Client } from '../../../../core/classes/models/client';
import { ClientService } from '../../../../core/http/client.service';
import { ConventionService } from '../../../../core/http/convention.service';
import { ActivatedRoute } from '@angular/router';
import { TitleService } from '../../../../core/services/title.service';
import { BreadcrumbsService } from '../../../../core/services/breadcrumbs.service';

@Component({
  selector: 'app-convention-edit',
  templateUrl: './convention-edit.component.html'
})
export class ConventionEditComponent implements OnInit {

  client: Client;
  convention: Convention;

  constructor(
    private route: ActivatedRoute,
    private clientService: ClientService,
    private conventionService: ConventionService,
    private titleService: TitleService,
    private breadcrumbsService: BreadcrumbsService,
  ) { }

  ngOnInit() {
    this.route.params.subscribe(param => {
      this.getClient(parseInt(param.clientId));
      this.getConvention(parseInt(param.conventionId));
    });
  }

  getClient(clientId: number) {
    this.clientService.getClient(clientId).subscribe(client => this.client = client);
  }

  getConvention(conventionId: number) {
    this.conventionService.getConvention(conventionId).subscribe(convention => {
      this.convention = convention;

      this.titleService.setTitles(`${convention.name} - Modifier`);
      this.breadcrumbsService.addBreadcrumb(
        [
          { title: 'Clients', url: '/clients' },
          { title: this.client.name, url: `/clients/${this.client.id}`},
          { title: convention.name, url: `/clients/${this.client.id}/conventions` },
          { title: 'Modifier', url: '' },
        ]
      );
    });
  }

}
