import React, { Component } from 'react';
import PropTypes from 'prop-types';
import { DropTarget } from 'react-dnd';
import MoreNewsComponent from './MoreNewsComponent';
import LatestNewsComponent from './LatestNewsComponent';
import EventsComponent from './EventsComponent';
import EditorPickComponent from './EditorPickComponent';
import MostViewedComponent from './MostViewedComponent';
import OtherStoriesComponent from './OtherStoriesComponent';
import SocialMediaComponent from './SocialMediaComponent';
import PrivacyPolicyComponent from './PrivacyPolicyComponent';
import ItemTypes from './ItemTypes';
import _ from 'lodash';
import $ from 'jquery';
import Config from './Config';
import Guid from 'guid';
import LetterNote from './LetterNote';

const style = {
  background: '#E6E6E6',
};

const boxTarget = {
  drop(props) {
    return { name: props.email };
  },
};

class ChinaInsightsNewsLetter extends Component {
static propTypes = {
   connectDropTarget: PropTypes.func.isRequired,
   isOver: PropTypes.bool.isRequired,
   canDrop: PropTypes.bool.isRequired,
   articles: PropTypes.any.isRequired,
 };
render() {
  const { canDrop, isOver, connectDropTarget } = this.props;
  const isActive = canDrop && isOver;

  let border = 'none';
  let borderStyle = 'none';
  let overflow = 'visible';
  let animation = 'none';
  let color = '';
  let baseURL = '';
  switch(this.props.site){
   case 'wp_2_':
      color = '#64a70b';
      baseURL = 'http://www.portfolio-adviser.com/';
     break;
   case 'wp_3_':
      color = '#0085CA';
      baseURL = 'http://www.international-adviser.com/';
     break;
   case 'wp_4_':
      color = '#d50032';
      baseURL = 'http://www.fundselectorasia.com/';
     break;
   case 'wp_5_':
      color = '#f2a900';
      baseURL = 'http://www.expertinvestoreurope.com/';
     break;
  }
    return connectDropTarget(
  <div style={{ ...style, border, borderStyle, overflow , animation}} id="emailInnerContent">

  <style dangerouslySetInnerHTML={{__html: `
          * {
                  padding: 0px;
                  line-height: normal;
          }
          img {
                  border: none;
          }
          p,ol li,ul li	{
                  color:#3b3b3b!important;
          }
          p {
                  margin: 0px;
                  padding: 0px;
          }
          .static_content a {
          color: #000000!important;
          }
          .ReadMsgBody {
                  width: 100%;
                  background-color: #ffffff;
          }
          .ExternalClass {
                  width: 100%;
                  background-color: #ffffff;
          }
          #emailInnerContent {
                  width: 100%;
                  margin: 0;
                  padding: 0;
                  -webkit-font-smoothing: antialiased;
                  font-family: Arial, Helvetica, sans-serif;
          }
          table {
                  border-collapse: collapse;
                  table-layout: fixed;
          }
          .menu td a {
                  color: #fff;
                  text-decoration: none;
                  font-size: 12px;
          }

          img {
                  max-width: 100%;
          }
          #emailInnerContent .chart_block td, #emailInnerContent .chart_block th {
                  border: 1px solid #ccc;
                  padding: 5px;
          }
          #emailInnerContent .chart_block th {
                  word-wrap: break-word;
          }
          #emailInnerContent .fund_linked:first-child {
                  text-align: center;
          }
          @media only screen and (max-width: 749px) {
                  #emailInnerContent .deviceWidth {
                          width: 620px !important;
                  }
                  #emailInnerContent .email_send td:first-child {
                          width: 40% !important;
                  }
                  #emailInnerContent .email_send td:last-child {
                          width: 60% !important;
                  }
                  #emailInnerContent .footer_content {
                          width: 99.9% !important;
                  }

                  #emailInnerContent .device_innerblock, #emailInnerContent .device_linked,#emailInnerContent .header-bg-block,#emailInnerContent .header-block,#emailInnerContent .sponser{
                          width: 100% !important;
                  }
                  #emailInnerContent .social_icon {
                          width: 30% !important;
                  }
                  #emailInnerContent .container:first-child {
                          width: 55% !important;
                  }

                  #emailInnerContent .footer_block {
                          width: 33.33% !important;
                  }
                  #emailInnerContent .linked:first-child {
                          width: 82% !important;
                  }
                  #emailInnerContent .linked:last-child {
                          width: 18% !important;
                  }
                  
                  
                  #emailInnerContent .more_news {
                          width: 150px !important;
                  }
                  #emailInnerContent .more_news td {
                          text-align: center !important;
                  }
                  #emailInnerContent .fund_linked:first-child {
                          width: 55% !important;
                  }
                  #emailInnerContent .fund_linked:last-child {
                          width: 40% !important;
                  }
                  #emailInnerContent .common_left:first-child {
                          width: 60% !important;
                  }
                  #emailInnerContent .common_left:last-child {
                          width: 40% !important;
                  }
          }
          @media only screen and (max-width: 640px) {
                  #emailInnerContent .deviceWidth {
                          width: 580px !important;
                  }
                  #emailInnerContent .header-block,#emailInnerContent .container,#emailInnerContent .header-bg-block, #emailInnerContent .chart_block,#emailInnerContent .container:first-child,body[yahoo] .container:last-child{
                          width: 100% !important;
                  }
                  

          }
          @media only screen and (max-width: 600px) {
                  #emailInnerContent .deviceWidth {
                          width: 540px !important;
                  }
                  #emailInnerContent .header-block,#emailInnerContent .header-bg-block {
                          width: 100% !important;
                  }
                  
          }
          @media only screen and (max-width: 560px) {
                  #emailInnerContent .deviceWidth {
                          width: 460px !important;
                  }
                  #emailInnerContent .linked:first-child {
                          width: 71% !important;
                  }
                  #emailInnerContent .linked:last-child {
                          width: 29% !important;
                  }
                  
                   
                  #emailInnerContent .social_icon {
                          width: 35% !important;
                  }
                  #emailInnerContent .footer_block tr:first-child td:first-child {
                          padding-left: 0px !important;
                          padding-right: 0px !important;
                  }
                  
                  #emailInnerContent .header-bg-block, #emailInnerContent .fund_linked:first-child, #emailInnerContent .fund_linked:last-child,#emailInnerContent .header-block,#emailInnerContent .container,#emailInnerContent .footer_block  {
                          width: 100% !important;
                  }
                  #emailInnerContent .full_wrap {
                          width: 100%;
                          display: inline-block;
                  }
                  #emailInnerContent .container_sub {
                          float: left;
                          width: 100%;
                  }
                  #emailInnerContent .container_sub:first-child {
                          padding: 20px 0px 0px !important;
                  }

          }
          @media only screen and (max-width: 479px) {
                  #emailInnerContent .deviceWidth {
                          width: 96% !important;
                          font-size: 14px !important;
                  }

                  #emailInnerContent .email_send td:first-child, #emailInnerContent .email_send td:last-child, #emailInnerContent .social_icon {
                          width: 50% !important;
                  }

                  #emailInnerContent .linked:last-child {
                          width: 100% !important;
                          text-align: center;
                          padding: 0px !important;
                  }
                  #emailInnerContent .linked:last-child td {
                          text-align: center;
                  }

                  #emailInnerContent .header-block, #emailInnerContent .linked:first-child, #emailInnerContent .common_left,#emailInnerContent .common_left:last-child, #emailInnerContent .common_left:first-child {
                          width: 100% !important;
                  }

                  #emailInnerContent .fund_linked:last-child  tr:first-child td:first-child {
                          padding-top: 15px;
                  }
                  #emailInnerContent .common_left:last-child td {
                          /* text-align: center !important; */
                          padding: 10px 0px 0px 0px !important;
                  }
          }
          .static_content p,.static_content em ,.static_content ul li, .static_content ol li{mso-line-height-rule:exactly;line-height:20px;}
          .static_content ul, .static_content ol {list-style-position: outside;margin-left: 15px;}
          .device_linked p {line-height: 20px;}
          td .white a {
                      color:#fff;
          }
    `}} />

      <table data-width="100%" data-border="0" cellPadding="0" cellSpacing="0" data-align="center" style={{textAlign: 'left', width: '100%',margin: '0px', borderCollapse: 'collapse',tableLayout: 'fixed',msoTableLspace:'0pt', msoTableRspace:'0pt', borderSpacing:'0px'}}>
                <tr>
                                <td>
                                        <table className="deviceWidth" style={{margin:'0px auto',width:'750px',textAlign:'center'}} cellSpacing="0" cellPadding="0" data-border="0" data-align="center" data-width="750">
                                                <tr>
                                                        <td>
                                                                <table  style={{textAlign: 'left', width: '100%', margin: '0px'}} data-align="center" data-width="100%"  cellSpacing="0" cellPadding="0" className="email_send">
                                                                        <tr>
                                                                                {this.props.site === 'wp_2_' ? <td data-align="left" data-width="280" style={{width:'280px',padding:'8px 10px 8px 10px',fontFamily: 'Arial, Helvetica, sans-serif',fontSize: '11px', textAlign: 'left'}}><a href="http://www.portfolio-adviser.com/" style={{color:'#000000',textDecoration:'none'}}>Portfolio Adviser Newsletter</a></td>: ''}
                                                                                {this.props.site === 'wp_3_' ? <td data-align="left" data-width="280" style={{width:'280px',padding:'8px 10px 8px 10px',fontFamily: 'Arial, Helvetica, sans-serif',fontSize: '11px', textAlign: 'left'}}><a href="http://www.international-adviser.com/" style={{color:'#000000',textDecoration:'none'}}>International Adviser Newsletter</a></td>: ''}
                                                                                {this.props.site === 'wp_4_' ? <td data-align="left" data-width="280" style={{width:'280px',padding:'8px 10px 8px 10px',fontFamily: 'Arial, Helvetica, sans-serif',fontSize: '11px', textAlign: 'left'}}><a href="http://www.fundselectorasia.com/" style={{color:'#000000',textDecoration:'none'}}>Fund Selector Asia Newsletter</a></td>: ''}
                                                                                {this.props.site === 'wp_5_' ? <td data-align="left" data-width="280" style={{width:'280px',padding:'8px 10px 8px 10px',fontFamily: 'Arial, Helvetica, sans-serif',fontSize: '11px', textAlign: 'left'}}><a href="http://www.expertinvestoreurope.com/" style={{color:'#000000',textDecoration:'none'}}>Expert Investor Newsletter</a></td>: ''}
                                                                                <td data-width="398" style={{width:'398px',padding:'8px 10px 8px 10px',fontFamily: 'Arial, Helvetica, sans-serif',fontSize: '11px',color: '#2D2C28', textAlign: 'right'}}>If you are unable to view this email, <a style={{color:'#000',textDecoration:'none'}} href="[*link.webversion_url*]">click here</a></td>
                                                                        </tr>
                                                                </table>
                                                        </td>
                                                </tr>
                                        </table>
                                </td>
                        </tr>
                        <tr>
                <td data-valign="top">
                        <table cellSpacing="0" cellPadding="0" data-align="center" data-width="750" data-bgcolor="#ffffff" style={{textAlign: 'left',width:'750px',borderLeft:'1px solid #CCCCCC',borderRight:'1px solid #CCCCCC',borderTop:'1px solid #CCCCCC',margin:'0px auto'}} className="deviceWidth">
                                <tr>
                                        <td style={{background:'#000',textAlign:'bottom',padding:'10px 9px 8px 9px'}} data-bgcolor="#000000" data-align="bottom">
                                        {this.props.site === 'wp_2_' ? <a href={baseURL}><img src="https://pa.cms-lastwordmedia.com/wp-content/uploads/email-template-images/newsletter_logo1.jpg" style={{maxWidth: '100%'}} alt="Portfolio Adviser"/></a> :''}
                                        {this.props.site === 'wp_3_' ? <a href={baseURL}><img src="https://pa.cms-lastwordmedia.com/wp-content/uploads/email-template-images/ia_newsletter.png" style={{maxWidth: '100%'}} alt="International Advisor"/></a> :''}
                                        {this.props.site === 'wp_4_' ? <a href={baseURL}><img src="https://pa.cms-lastwordmedia.com/wp-content/uploads/email-template-images/fsa_newsletter.jpg" style={{maxWidth: '100%'}} alt="Fund Selector Asia"/></a> :''}
                                         {this.props.site === 'wp_5_' ? <a href="http://www.expertinvestoreurope.com/"><img src="http://assets.kreatio.net/expert_investor_europe/images/newsletter_logo.png" style={{maxWidth: '100%'}} alt="Expert Investor"/></a> :''}
                                        </td>
                                        <td style={{padding:'10px 9px 8px 9px', textAlign:'right', background:'#000'}} data-bgcolor="#000000" data-align="right">
					      <a href="http://www.fundselectorasia.com/"><img src="https://pa.cms-lastwordmedia.com/wp-content/uploads/email-template-images/chinanewsletter_right_logo.png" style={{maxWidth: '100%'}} alt="Fund Selector Asia"/></a>
					</td>
                                        </tr>
                                        </table>
                                <table data-width="748" cellSpacing="0" cellPadding="0" data-border="0" data-align="center" className="deviceWidth" style={{background:'#fff', width:'750px',borderLeft:'1px solid #CCCCCC',borderRight:'1px solid #CCCCCC',margin:'0px auto'}}>
                                {this.props.staticHighlight === 'top' ? <tr><td style={{ animation : 'blink .5s step-end infinite alternate', border: '2px solid'}}><div><br/></div></td></tr> : ''}
                                {this.props.showTopLeaderboard !== '0' ? <tr>
                                  <td style={{position: 'relative', background: '#fff'}}>
                                  <div dangerouslySetInnerHTML={{__html: ( this.props.showTopLeaderboard === '1' ? this.props.topLeaderboard : ( this.props.showTopLeaderboard === '2' ? this.props.topLeaderboardB : ( this.props.showTopLeaderboard === '3' ? this.props.topLeaderboardC : ( this.props.showTopLeaderboard === '4' ? this.props.topLeaderboardD : ( this.props.showTopLeaderboard === '5' ? this.props.topLeaderboardE : ( this.props.showTopLeaderboard === '6' ? this.props.topLeaderboardF : "" ) ) ) ) ) ) }}></div> 
                                  <img src="https://pa.cms-lastwordmedia.com//wp-content/plugins/email-builder/cross.png" className="cross-img" style={{width:'10px',cursor:'pointer',position: 'absolute',right:'10px',top:'10px'}} id="Top_Leaderboard" onClick={this.props.onRemoveStatic}/>
                                  <LetterNote letter={this.props.showTopLeaderboard} />
                                  </td>
                                </tr> : ''}
                                        <tr>
                                                <td>
                                                <table style={{width:'748px', margin: '0px'}} data-width="748" cellSpacing="0" cellPadding="0" data-align="center" className="deviceWidth">
<tr>
                                                                <td>
                                                                <table className="deviceWidth" style={{width: '405px', textAlign: 'left', float: 'left'}} data-align="center" data-width="405" cellSpacing="0" cellPadding="0">
                                                                        <tbody><tr>
        <td style={{padding:'0px 10px 0px 9px',verticalAlign: 'top',margin:'0px'}}>
        <LatestNewsComponent articles={this.props.articles} highlight={this.props.highlight} onArticleDropped={this.props.onArticleDropped} color={color} onRemoveArticle={this.props.onRemoveArticle} isAllBlocks="true" isChinaNews="true"/>
        </td>
</tr>
                                                            </tbody></table>
                                                              <table style={{textAlign:'left',width:'320px', float: 'right'}} data-width="320" className="container deviceWidth" data-align="right">
                <tbody><tr>
                        <td style={{padding:'0px 9px 0px 10px', verticalAlign: 'top',margin:'0px'}}>
                                <table style={{width: '100%'}} data-width="100%">
                                                        <tbody><tr>
                                                                <td style={{padding:'13px 0px 10px 0px'}} data-align="center">
                                                                        <table className="subscribe" style={{width: '100%'}} data-width="100%">
<tbody>
{this.props.staticHighlight === 'staticImage1' ? <tr><td style={{ animation : 'blink .5s step-end infinite alternate', border: '2px solid'}}><div><br/></div></td></tr> : ''}
{ this.props.showStaticImage1 !== '0' ? <tr>
  <td style={{position: 'relative', background: '#fff'}}>
   <div dangerouslySetInnerHTML={{__html: ( this.props.showStaticImage1 === '1' ? this.props.staticImage1 : ( this.props.showStaticImage1 === '2' ? this.props.staticImage1B : ( this.props.showStaticImage1 === '3' ? this.props.staticImage1C : ( this.props.showStaticImage1 === '4' ? this.props.staticImage1D : '' ) ) ) ) }}></div> 
  <img src="https://pa.cms-lastwordmedia.com//wp-content/plugins/email-builder/cross.png" className="cross-img" style={{width:'10px',cursor:'pointer',position: 'absolute',right:'10px',top:'10px'}} id="Static_Image_1" onClick={this.props.onRemoveStatic}/>
  <LetterNote letter={this.props.showStaticImage1} />
  </td>
</tr> : ''}
</tbody>
</table>
                                                                </td>
                                                        </tr>
                                                        <tr>
                <td>
                <EventsComponent selectedEventArticles={this.props.selectedEventArticles} onArticleDropped={this.props.onArticleDropped} highlight={this.props.highlight} color={color} onRemoveEvent={this.props.onRemoveEvent} isAllBlocks="true"/>
                </td>
        </tr>
<tr>
        <td>
        <MoreNewsComponent selectedMoreNewsArticles={this.props.selectedMoreNewsArticles} onArticleDropped={this.props.onArticleDropped} highlight={this.props.highlight} color={color} onRemoveArticle={this.props.onRemoveArticle} isAllBlocks="true"/>
        </td>
</tr>
                                </tbody></table>
                        </td>
            </tr>
</tbody></table>
                                                              </td>
                                                           </tr>
                                                                                        <tr>
                                                                                        <td style={{padding:'13px 10px 10px 10px'}}>
                                                                                                <table className="subscribe" style={{width: '728px',textAlign:'center'}} data-width="728" data-align="center">
                                                                                                <tbody>
                                                 {this.props.staticHighlight === 'staticImage2' ? <tr><td style={{ animation : 'blink .5s step-end infinite alternate', border: '2px solid'}}><div><br/></div></td></tr> : ''}
                                                 {this.props.showStaticImage2 !== '0' ? <tr>
                                                  <td style={{position: 'relative', background: '#fff'}}>
                                                                                                <div dangerouslySetInnerHTML={{__html: ( this.props.showStaticImage2 === '1' ? this.props.staticImage2 : ( this.props.showStaticImage2 === '2' ? this.props.staticImage2B : ( this.props.showStaticImage2 === '3' ? this.props.staticImage2C : ( this.props.showStaticImage2 === '4' ? this.props.staticImage2D : '' ) ) ) ) }}></div> 
                                                                                                <img src="https://pa.cms-lastwordmedia.com//wp-content/plugins/email-builder/cross.png" className="cross-img" style={{width:'10px',cursor:'pointer',position: 'absolute',right:'10px',top:'10px'}} id="Static_Image_2" onClick={this.props.onRemoveStatic}/>
                                                                                                <LetterNote letter={this.props.showStaticImage2} />
                                                                                                </td></tr>: ''}
</tbody></table></td>
                                                                                        </tr>
                                                           <tr>
        <td style={{padding:'0px 10px'}}>
        <table className="device_innerblock" style={{width:'728px', textAlign:'center'}} data-width="728" data-align="center" >
                <tr>
                        <td data-align="left" style={{textAlign:'left',padding:'0px 6px 6px 6px',color: '#000000', fontFamily:'Arial, Helvetica, sans-serif',fontSize: '18px',fontWeight:'bold'}}><font style={{fontFamily:'Arial, Helvetica, sans-serif'}}>Other stories from Last Word</font></td>
                </tr>
        </table></td>
</tr>
<tr>
        <td style={{padding:'0px 10px 0px 10px'}}>
        <OtherStoriesComponent color={color} highlight={this.props.highlight} site={this.props.site} selectedStoryArticles={this.props.selectedStoryArticles} onArticleDropped={this.props.onArticleDropped}/>
        </td>
</tr>
                                                           <tr>
                                                                                                <td style={{padding:'0px 9px; 0px 9px'}}>
                                                                                                        <table className="device_innerblock" style={{width:'728px', textAlign: 'center'}} data-align="center" data-width="728">
                                                                                                                        <tr>
                                                                                                                                <td style={{padding:'10px 0px 10px 0px', textAlign: 'center'}}>
                                                                                                                                </td>
                                                                                                                        </tr>
                                                                                                        </table>
                                                                                                </td>
                                                                                        </tr>
                                                                                        {this.props.staticHighlight === 'footer' ? <tr><td style={{ animation : 'blink .5s step-end infinite alternate', border: '2px solid'}}><div><br/></div></td></tr> : ''}
                                                                                        {this.props.showFooterLeaderboard !== '0' ? <tr>
                                                                                          <td style={{position: 'relative', background: '#fff'}}>
                                                                                           <div dangerouslySetInnerHTML={{__html: ( this.props.showFooterLeaderboard === '1' ? this.props.footerLeaderboard : ( this.props.showFooterLeaderboard === '2' ? this.props.footerLeaderboardB : ( this.props.showFooterLeaderboard === '3' ? this.props.footerLeaderboardC : ( this.props.showFooterLeaderboard === '4' ? this.props.footerLeaderboardD : ( this.props.showFooterLeaderboard === '5' ? this.props.footerLeaderboardE : ( this.props.showFooterLeaderboard === '6' ? this.props.footerLeaderboardF : "" ) ) ) ) ) ) }}></div> 
                                                                                          <img src="https://pa.cms-lastwordmedia.com//wp-content/plugins/email-builder/cross.png" className="cross-img" style={{width:'10px',cursor:'pointer',position: 'absolute',right:'10px',top:'10px'}} id="Footer_Leaderboard" onClick={this.props.onRemoveStatic}/>
                                                                                          <LetterNote letter={this.props.showFooterLeaderboard} />
                                                                                          </td>
                                                                                        </tr> : ''}
                                                           <tr>
                                                              <td style={{padding: '15px 15px 15px 15px', background: '#000'}} className="footer" data-bgcolor="#000000">
                                                                                                <table style={{width:'100%', textAlign: 'left'}} className="footer_content" data-width="100%" data-align="left">
                                                                                                <tr>
                                                                                                        <td style={{padding:'0px 0px 10px 0px', textAlign: 'left'}} data-align="left" data-valign="top">
                                                                                                         <SocialMediaComponent site={this.props.site} />
                                                                                                        </td>
                                                            </tr>
                                                                        <tr>
                                                                                <td>
                                                                                        <table style={{width:'100%'}} data-width="100%">
                                                                                                <tr>
                                                                                                        <td className="footer_left" data-valign="bottom" data-align="left" data-width="80%" style={{padding:'0px 20px 0px 0px', textAlign: 'left', width: '80%'}}>
                                                                                                                <table style={{width:'100%'}} data-width="100%">
                                                                                                                        <tr>
                                                                                                                                <td className="white" style={{color:'#fff',fontFamily:'Arial, Helvetica, sans-serif',fontSize:'11px',textDecoration: 'none',fontWeight: 'bold',padding:'0px 0px 3px 0px'}}> If you wish to unsubscribe from this email, <a href="[*link.prefill_url(1)*]" style={{color:'#FFFFFF',textDecoration: 'none',fontFamily: 'Arial, Helvetica, sans-serif'}}>please click here</a></td>
                                                                                                                        </tr>
                                                                                                                        <tr>
                                                                                                                                                                <td className="white" style={{padding:'0px 0px 10px 0px', color:'#fff',fontFamily:'Arial, Helvetica, sans-serif',fontSize:'11px',textDecoration: 'none',fontWeight: 'bold'}}>Do not reply to this email.</td>
                                                                                                                                                        </tr>
                                                                                                                                                        <tr>
                                                                                                                                                                  <td className="white" style={{padding:'0px 0px 10px 0px', color:'#C2C2C2',fontFamily:'Arial, Helvetica, sans-serif',fontSize:'11px'}}>
                                                                                                                                                                            <PrivacyPolicyComponent site={this.props.site} />
                                                                                                                                                                            </td>
                                                                                                                                                        </tr>
                                                                                                                                                        <tr>
                                                                                                                                                                <td className="white" style={{color:'#fff',fontFamily: 'Arial, Helvetica, sans-serif',fontSize:'10px',padding:'0px 0px 3px 0px'}}><font style={{fontFamily:'Arial, Helvetica, sans-serif'}}> Published by Last Word Media Limited, Fleet House, 1st Floor, 59-61 Clerkenwell Road, London, EC1M 5LA. Copyright (c) { new Date().getFullYear() }.</font></td>
                                                                                                                                                        </tr>
                                                                                                                                                        <tr>
                                                                                                                                                                <td className="white" style={{color:'#fff',fontFamily:'Arial, Helvetica, sans-serif',fontSize:'10px'}}><font style={{fontFamily:'Arial, Helvetica, sans-serif'}}>All rights reserved. Company Reg. No. 05573633. VAT. No. 672 411 728.</font></td>
                                                                                                                                                        </tr>
                                                                                                                 </table>
                                                                                                        </td>
                                                                                                        <td data-valign="bottom" data-align="right" data-width="20%" className="footer_left" style={{width: '20%', textAlign:'right'}}><a href="http://www.lastwordmedia.com" target="_blank"><img src="https://pa.cms-lastwordmedia.com/wp-content/uploads/email-template-images/newsletter_lastword1.png" alt="logo" style={{maxWidth: '100%',display:'block'}} /></a></td>
                                                                                                         </tr>
                                                                                                </table>
                                                                                        </td>
                                                                                        </tr>
                                                                                </table>
                                                                        </td>
                                                                        </tr>
                                                        </table>
                                                </td>
                                                </tr>
                                </table>
                        </td>
                </tr>
            </table>     				
        </div>
    );
  }
}

export default DropTarget(ItemTypes.BOX, boxTarget, (connect, monitor) => ({
  connectDropTarget: connect.dropTarget(),
  isOver: monitor.isOver(),
  canDrop: monitor.canDrop(),
})
)(ChinaInsightsNewsLetter);
