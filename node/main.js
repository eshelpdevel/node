/*
###############################################################################################################
# Date          |    Type    |   Version                                                                      # 
############################################################################################################### 
# 07-05-2025    |   Create   |  1.1.0705.2025                                                                 #
############################################################################################################### 
*/

require('dotenv/config');
var mysql = require('mysql');
const express = require('express');
var bodyParser = require("body-parser");
var ipServ = "10.0.5.231";
var url_api_fin = "https://10.0.69.28:8443";
const port = process.env.PORT || 8766; //;

var cron = require('node-cron');
const fs = require('fs');
const { exec } = require('child_process');
var cronList = []
var moment = require('moment');
// const today = moment();
var fetch = require('node-fetch');
const https = require('https');

const httpsAgent = new https.Agent({
  rejectUnauthorized: false,
});

var stconn = 0;

var conn = mysql.createConnection({
  host : process.env.DB_HOST,
  user : process.env.DB_USER,
  password : process.env.DB_PASSWORD,
  database : process.env.DB_DATABASE
});

const app = express();
app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: true }));

app.get('/', (req, res) => {
  res.send('Service History WABACC.')
});



app.post('/blashwa', async function (req, res) {

    const channel = req.body.channel;
    const ref = req.body.ref;
    const source = req.body.source;
    const destination = req.body.destination;
    const type = req.body.type;
    const body = req.body.body;

    res.json({
        code: "200",
        message: "Success!"
    });


    const parms = JSON.stringify(
      {
        'prm_type': type,
        'prm_phone': destination,
        'prm_msg': body
      });

    var serv_time = moment().format('YYYY-MM-DD HH:mm:ss');
    console.log("[" + serv_time + "] => Params : " + parms);
    console.log(" ");


    try {

        var vparams = {};
        var totpars = 0;
        Object.entries(req.body).forEach(([key, value]) => {
            if (key != "endpoint") {
                vparams[key] = value;
            } totpars++;
        });

        if (totpars == 0) {
            return false;
        }

        const params = JSON.stringify(vparams);

        // const params = new URLSearchParams();
        //     params.append('channel', channel);
        //     params.append('ref', ref);
        //     params.append('source', source);
        //     params.append('destination', destination);
        //     params.append('type', type);
        //     params.append('body', body);

        console.log(params);
        console.log(" ");

        const response = await fetch('https://crmreport.wom.co.id/womwaba/service/sosmed/other/blast.php',
            {
                method: 'POST',
                agent: httpsAgent,
                headers: {
                    'Content-Type': 'application/json'
                },
                body: params
            });

        try {
            // const resp = await response.json();
            console.log(response);
        } catch (error) {
            console.log(error);
        }

    } catch (error) {
        console.log(error);
    }

});

app.post('/blashparswa', async function (req, res) {

    const channel = req.body.channel;
    const ref = req.body.ref;
    const source = req.body.source;
    const destination = req.body.destination;
    const type = req.body.type;
    const body = req.body.body;

    res.json({
        code: "200",
        message: "Success!"
    });


    const parms = JSON.stringify(
      {
        'prm_type': type,
        'prm_phone': destination,
        'prm_msg': body
      });

    var serv_time = moment().format('YYYY-MM-DD HH:mm:ss');
    console.log("[" + serv_time + "] => Params : " + parms);
    console.log(" ");


    try {

        var vparams = {};
        var totpars = 0;
        Object.entries(req.body).forEach(([key, value]) => {
            if (key != "endpoint") {
                vparams[key] = value;
            } totpars++;
        });

        if (totpars == 0) {
            return false;
        }

        const params = JSON.stringify(vparams);

        console.log(params);
        console.log(" ");

        const response = await fetch('https://crmreport.wom.co.id/womwaba/service/sosmed/other/afterblast.php',
            {
                method: 'POST',
                agent: httpsAgent,
                headers: {
                    'Content-Type': 'application/json'
                },
                body: params
            });

        try {
            // const resp = await response.json();
            console.log(response);
        } catch (error) {
            console.log(error);
        }

    } catch (error) {
        console.log(error);
    }

});


app.listen(port, ipServ, () => {
  console.log(`Service app listening on port ${port}`);

});