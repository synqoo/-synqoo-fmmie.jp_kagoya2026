##          Movable Type configuration file                   ##
##                                                            ##
## This file defines system-wide settings for Movable Type    ##
## In total, there are over a hundred options, but only those ##
## critical for everyone are listed below.                    ##
##                                                            ##
## Information on all others can be found at:                 ##
## http://www.movabletype.org/documentation/appendices/config-directives/ ##

################################################################
##################### REQUIRED SETTINGS ########################
################################################################

# The CGIPath is the URL to your Movable Type directory
CGIPath    /mt/

# The StaticWebPath is the URL to your mt-static directory
# Note: Check the installation documentation to find out 
# whether this is required for your environment.  If it is not,
# simply remove it or comment out the line by prepending a "#".
StaticWebPath   /mt/mt-static/
StaticFilePath /home/kir691871/public_html/backsite/mt/mt-static

#================ DATABASE SETTINGS ==================
#   CHANGE setting below that refer to databases 
#   you will be using.

##### MYSQL #####
ObjectDriver DBI::mysql
Database mt7
DBUser kir691871
DBPassword 2d791a8032876e7e
DBHost o4043-462.kagoya.net

## Change setting to language that you want to using.
DefaultLanguage en_US
#DefaultLanguage de
#DefaultLanguage es
#DefaultLanguage fr
#DefaultLanguage ja
#DefaultLanguage nl

EmailAddressMain xc2s-oohr@asahi-net.or.jp
MailTransfer sendmail
SendMailPath /usr/lib/sendmail
    
DefaultLanguage ja

ImageDriver ImageMagick
includephppath /home/kir691871/public_html/fmmie.jp/

