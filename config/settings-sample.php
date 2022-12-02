<?php
/**
 * NEXUS application global settings
 * @author Pedro CADETE <pedro@hyperion-web.fr>
 * @link https://ressources.pluxml.org
 */

const DEBUG = FALSE;

const DIR_DOWNLOAD = '/datas';
const DIR_TMP = DIR_DOWNLOAD . '/tmp';
const DIR_PLUGINS = DIR_DOWNLOAD . '/plugins';
const DIR_THEMES = DIR_DOWNLOAD . '/themes';

const PLUGINS_MAX_SIZE = '10MB';

const DB_HOST = 'localhost';
//const DB_HOST = '127.0.0.1';
//const DB_HOST = 'mysql';
const DB_DBNAME = '';
const DB_CHARSET = 'utf8';
const DB_PORT = '3306';
const DB_USER = '';
const DB_PASSWORD = '';

const MAIL_PROVIDER = ''; // set "smtp" to use SMTP host and authentification otherwise set empty ('') to use the PHP function mail()
const MAIL_SMTP_HOST = '';
const MAIL_SMTP_USERNAME = '';
const MAIL_SMTP_PASSWORD = '';
const MAIL_SMTP_PORT = '465';
const MAIL_SMTP_SECURITY = 'ssl'; //possible values : 'ssl' or 'tls'

const AUTH_SIGNUP_LIFETIME = 4; // hours
const MAX_SUBSCRIBERS_CNT = 30;

const MAIL_FROM = 'name@mail.com';
const MAIL_FROM_NAME = 'MailName';
const MAIL_NEWUSER_SUBJECT = 'Welcome to PluXml Nexus';
const MAIL_NEWUSER_BODY = '<p>Hello ##USERNAME##</p>To complete your signup and be able to login to <a href="https://ressources.pluxml.org">ressources.pluxml.org</a>, please confirm your email address by clicking the link below</p>##TOKEN##<p>This link will expire in 24h.</p>';
