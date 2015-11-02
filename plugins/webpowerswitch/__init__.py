from lxml import html
import requests
import re


def run(self):
    print("Hello from the Web Power Switch Plugin!")

    
    
def getControlObjectClassGUID():
    return "60744a91-2ef8-4fa1-84a0-bc51bb5f9287"

def getControlObjectProperties():
    return "Some outlets"
    
def getControlPage(IP,username,password):
    """
    Get the WebPowerSwitch's control page
    """
    page = requests.get("http://192.168.10.53/index.htm",auth=('admin','HaveFaith2'))
    tree = html.fromstring(page.text)
    
def getOutlets():
    """
        Get the Outlets
    """
    outletNumbers =  tree.xpath('/html/body/font/table/tr/td[2]/table[2]/tr[position()>2]/td[1]/text()')
    outletNames =  tree.xpath('/html/body/font/table/tr/td[2]/table[2]/tr[position()>2]/td[2]/text()')
    outletStates =  tree.xpath('/html/body/font/table/tr/td[2]/table[2]/tr[position()>2]/td[3]/b/font/text()')


def getSetupPage(IP,username,password):

