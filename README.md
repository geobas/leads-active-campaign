## Technical test about a RESTful API written in Laravel.

### Description
The assignment is to create a restful API that will persist Leads (potential customers) as well as sync them to a marketing automation platform (ActiveCampaign).

---

### Set up
```
1. git clone git@github.com:geobas/leads-active-campaign.git leads_active_campaign
2. docker-compose up -d && docker exec -it laravel-active-campaign bash
3. composer install
4. composer run-script post-root-package-install
5. Modify the generated .env accordingly
6. ./artisan optimize
7. Go to http://localhost:8080
```

### Postman collection
* Download [here](https://api.postman.com/collections/18571919-08860d87-642e-42e4-89f1-b60d37e84273?access_key=PMAT-01GNZ88KKCX44RHGJA0MDBE3SC)
* Create a new Environment and set a 'domain' variable

### Instructions
```
1. Create an ActiveCampaign list by sending a request to the relevant endpoint
2. Save some leads using list's id that was returned from previous step
3. Get all stored leads
4. All leads stored to MongoDB are also added to the ActiveCampaign list that was created at first step
5. Edit or delete a lead by passing its '_id' as URL parameter
6. Sync all leads to a new ActiveCampaign list by sending a request to the relevant endpoint
```
