## Technical test about a RESTful API written in Laravel.

### Description
The assignment is to create a restful API that will persist Leads (potential customers) as well as sync them to a marketing automation platform (ActiveCampaign).

---

### Set up
```
1. git clone git@github.com:geobas/leads-active-campaign.git leads_active_campaign
2. composer install
3. composer run-script post-root-package-install
4. Modify the generated .env accordingly
5. artisan optimize
```

### Postman collection
* Download [here](https://www.getpostman.com/collections/21006413dab0e4e6ce1d)
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
