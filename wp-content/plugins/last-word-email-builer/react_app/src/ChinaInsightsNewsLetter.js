import React, { Component } from 'react';
import PropTypes from 'prop-types';
import { DropTarget } from 'react-dnd';
import ItemTypes from './ItemTypes';
import _ from 'lodash';
import $ from 'jquery';
import Config from './Config';
import Guid from 'guid';


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
  switch(this.props.site){
   case 'wp_2_':
      color = '#64a70b';
     break;
   case 'wp_3_':
      color = '#0085CA';
     break;
   case 'wp_4_':
      color = '#d50032';
     break;
   case 'wp_5_':
      color = '#f2a900';
     break;
  }
    return connectDropTarget(
  <div style={{ ...style, border, borderStyle, overflow , animation}}>
      <table style={{textAlign: 'left', width: '100%',margin: '0px', borderCollapse: 'collapse',tableLayout: 'fixed',msoTableLspace:'0pt', msoTableRspace:'0pt', borderSpacing:'0px'}}>
                <tr>
                                <td>
                                        <table className="deviceWidth" style={{margin:'0px auto',width:'750px',textAlign:'center'}}>
                                                <tr>
                                                        <td>
                                                                <table  style={{textAlign: 'left', width: '100%', margin: '0px'}} className="email_send">
                                                                        <tr>
                                                                                <td style={{width:'280px',padding:'8px 10px 8px 10px',fontFamily: 'Arial, Helvetica, sans-serif',fontSize: '11px', textAlign: 'left'}}><a href="http://www.expertinvestoreurope.com/" style={{color:'#000000',textDecoration:'none'}}>Expert Investor Newsletter</a></td>
                                                                                <td style={{width:'398px',padding:'8px 10px 8px 10px',fontFamily: 'Arial, Helvetica, sans-serif',fontSize: '11px',color: '#2D2C28', textAlign: 'right'}}>If you are unable to view this email, <a style={{color:'#000',textDecoration:'none'}} href="[*link.webversion_url*]">click here</a></td>
                                                                        </tr>
                                                                </table>
                                                        </td>
                                                </tr>
                                        </table>
                                </td>
                        </tr>
                        <tr>
                <td>
                        <table style={{textAlign: 'left',width:'750px',borderLeft:'1px solid #CCCCCC',borderRight:'1px solid #CCCCCC',borderTop:'1px solid #CCCCCC',margin:'0px auto'}} className="deviceWidth">
                                <tr>
                                        <td style={{background:'#000',textAlign:'bottom',padding:'10px 9px 8px 9px'}}>
                                         {this.props.site === 'wp_2_' ? <a href="http://www.expertinvestoreurope.com/"><img src="https://pa.cms-lastwordmedia.com/wp-content/uploads/email-template-images/newsletter_logo1.jpg" style={{maxWidth: '100%'}} alt="Expert Investor"/></a> :''}
                                         {this.props.site === 'wp_3_' ? <a href="http://www.international-adviser.com/"><img src="http://www.international-adviser.com/images/newsletter_logo.png" style={{maxWidth: '100%'}} alt="Expert Investor"/></a> :''}
                                         {this.props.site === 'wp_4_' ? <a href="http://www.fundselectorasia.com/"><img src="http://www.fundselectorasia.com/images/newsletter_logo.png" style={{maxWidth: '100%'}} alt="Expert Investor"/></a> :''}
                                         {this.props.site === 'wp_5_' ? <a href="http://www.expertinvestoreurope.com/"><img src="http://assets.kreatio.net/expert_investor_europe/images/newsletter_logo.png" style={{maxWidth: '100%'}} alt="Expert Investor"/></a> :''}
                                        </td>
                                                </tr>
                                                {this.props.staticHighlight === 'top' ? <tr><td style={{ animation : 'blink .5s step-end infinite alternate', border: '2px solid'}}><div><br/></div></td></tr> : ''}
                                                {this.props.topLeaderboard.length > 0 && this.props.showTopLeaderboard === '1' ? <tr>
                                                  <td style={{position: 'relative', background: '#fff'}}>
                                                  <div dangerouslySetInnerHTML={{__html:this.props.topLeaderboard}}></div> 
                                                  <img src="https://pa.cms-lastwordmedia.com//wp-content/plugins/email-builder/cross.png" style={{width:'10px',cursor:'pointer',position: 'absolute',right:'10px',top:'10px'}} id="Top_Leaderboard" onClick={this.props.onRemoveStatic}/>
                                                  </td>
                                                </tr> : ''}
                                        </table>
                                <table className="deviceWidth" style={{textAlign: 'center',background:'#fff', width:'750px',borderLeft:'1px solid #CCCCCC',borderRight:'1px solid #CCCCCC',margin:'0px auto'}}>
                                        <tr>
                                                <td>
                                                <table style={{textAlign: 'center',width:'100%', margin: '0px'}}>
<tr>
                                                                <td>
                                                                <table style={{width: '490px', textAlign: 'left', float: 'left'}}>
                                                                        <tbody><tr>
        <td style={{padding:'0px 10px 0px 9px',verticalAlign: 'top',margin:'0px'}}>
        <table style={this.props.highlight === 'articles' ? { animation : 'blink .5s step-end infinite alternate', border: '2px solid', width: '100%'} : {width: '100%'}}>
                <tbody><tr>
                        <td style={{fontSize: '22px',fontWeight: 'normal',borderBottom: '1px solid #e5eaee',padding: '10px 0px 3px 0px',fontFamily:'Georgia', color}}>
                                <font style={{fontFamily:'Georgia'}}> Latest China News </font>
                        </td>
                </tr>

                {this.props.articles.map((article,key) => {
                                return article !== null ?  <tr key={key}>
                        <td>
                        <table style={{borderBottom: '1px solid #e5eaee', width: '100%', position: 'relative'}}>
                                <tbody><tr>
                                                                        <td className="container_sub" style={{padding:'20px 10px 14px 0px',verticalAlign: 'top'}}> 
                                                                                <a href={article.guid}>
                                                                                 <img src={ article.featured_image !== null ? article.featured_image : "http://www.expertinvestoreurope.com/w-images/2dd14d1d-57c2-4dfb-b6c9-ed1644ebb96d/2/cliffdownmoneydanger-219x122.jpg"} style={{maxWidth:'100%'}} title="" />
                                                                                 </a>
                                                                        </td>
                                                                        <td className="container_sub" style={{verticalAlign: 'top',padding:'13px 0px 14px'}}>						
                                                                                <table width="100%">
                                                                                                <tbody><tr>
                                                                                                        <td style={{padding: '0px 0px 7px'}}> <a href={article.guid} style={{fontSize: '14px',fontFamily:'Arial, Helvetica, sans-serif',textDecoration: 'none', color}} title="ANALYSIS: Sailing the macro winds in Japanese equities"><font style={{fontFamily:'Arial, Helvetica, sans-serif'}}>{article.post_title}</font></a> </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                        <td style={{color: '#2c2c2c',fontSize: '14px',fontFamily: 'Arial, Helvetica, sans-serif',lineHeight: '20px'}}><font style={{fontFamily:'Arial, Helvetica, sans-serif'}} dangerouslySetInnerHTML={{__html:article.post_excerpt.substring(0,500)}}></font></td>
                                                                                                </tr>
                                                                                </tbody></table>
                                                                                <img src="https://pa.cms-lastwordmedia.com//wp-content/plugins/email-builder/cross.png" style={{width:'10px',cursor:'pointer',position: 'absolute',right:'10px',top:'10px'}} id={article.ID} onClick={this.props.onRemoveArticle}/>
                                                                        </td>
                                </tr>
                        </tbody></table>
                        </td>
                </tr> : ''
                })}
        </tbody></table>
        </td>
</tr>
                                                            </tbody></table>
                                                               <table className="container" style={{width: '235px', textAlign: 'right'}}>
                <tbody><tr>
                        <td style={{padding:'0px 9px 0px 10px', verticalAlign: 'top',margin:'0px'}}>
                                <table style={{width: '100%'}}>
                                                        <tbody><tr>
                                                                <td style={{padding:'13px 0px 10px 0px'}}>
                                                                        <table className="subscribe" style={{width: '100%'}}>
<tbody>
{this.props.staticHighlight === 'newsletter' ? <tr><td style={{ animation : 'blink .5s step-end infinite alternate', border: '2px solid'}}><div><br/></div></td></tr> : ''}
{ this.props.newsletterSubscribe.length > 0 && this.props.showNewsletterSubscribe === '1' ? <tr>
  <td style={{position: 'relative', background: '#fff'}}>
   <div dangerouslySetInnerHTML={{__html:this.props.newsletterSubscribe}}></div>
  <img src="https://pa.cms-lastwordmedia.com//wp-content/plugins/email-builder/cross.png" style={{width:'10px',cursor:'pointer',position: 'absolute',right:'10px',top:'10px'}} id="Newsletter_Subscribe" onClick={this.props.onRemoveStatic}/>
  </td>
</tr> : ''}
</tbody>
</table>
                                                                </td>
                                                        </tr>
                                                        <tr>
                <td>
                        <table style={this.props.highlight === 'events' ? {animation : 'blink .5s step-end infinite alternate', border: '2px solid', width: '100%'} : {width: '100%'}}>
                                        <tbody><tr>
                                                <td style={{color,fontSize: '22px',fontWeight: 'normal',borderBottom: '1px solid #e5eaee',padding: '10px 0px 3px 0px',fontFamily:'Georgia'}}> 
                                                        <font style={{fontFamily:'Georgia'}}>
                                                                Events
                                                        </font> 
                                                </td>
                                        </tr>
                                          {this.props.eventArticles.map((article, key) => {
return <tr key={key}>
                <td>
                        <table style={{width: '100%'}}>
                                <tbody>
                                                <tr>
                                                        <td style={{padding:'7px 0px 7px', position: 'relative'}}>
                                                                <a href="http://lastwordmedia.eventscase.com/EN/PAAlternatives17" style={{color,fontSize: '14px',fontFamily:'Arial, Helvetica, sans-serif',textDecoration: 'none'}}><font>{article.post_title}</font></a>
                                                                <img src="https://pa.cms-lastwordmedia.com//wp-content/plugins/email-builder/cross.png" style={{width:'10px',cursor:'pointer',position: 'absolute',right:'10px',top:'10px'}} id={article.ID} onClick={this.props.onRemoveEvent}/>
                                                        </td>
                                                </tr>
                                  <tr>
                                     <td style={{fontFamily:'Arial, Helvetica, sans-serif',fontSize: '14px',padding:'0px 0px 2px 0px',color: '#2c2c2c'}}>
                                        <font>
                                        {(new Date(article.post_date)).toDateString()}
                                        </font>
                                     </td>
                                  </tr>
                                </tbody>
                        </table>
                </td>
        </tr>
                                        })}
                        </tbody></table>
                </td>
        </tr>
<tr>
        <td>
                <table style={this.props.highlight === 'editor' ? {animation : 'blink .5s step-end infinite alternate', border: '2px solid', width: '100%'} : {width: '100%'}}>
                                <tbody><tr>
                                        <td style={{color,fontSize: '22px',fontWeight: 'normal',borderBottom: '1px solid #e5eaee',padding:'20px 0px 3px 0px',fontFamily:'Georgia'}}>
                                                 <font>Editor's pick</font>
                                        </td>
                                </tr>
                                                 {this.props.editorArticles.map((article, key) => {
                                                return <tr key={key}>
                                                        <td>
                                                                <table style={{width: '100%', textAlign: 'left', position: 'relative'}}>
                                                                                        <tbody><tr>
                                                                                                <td style={{padding: '12px 0px 12px 0px',borderBottom: '1px solid #e5eaee'}}>
                                                                                                        <a href="http://www.portfolio-adviser.com/news/1037528/standard-life-aberdeen-confirm-creation-gbp11bn-investment-giant" style={{color,fontSize: '14px',fontFamily:'Arial, Helvetica, sans-serif',textDecoration: 'none'}} title={article.post_title}><font>{article.post_title}</font></a> 
                                                                                                        <img src="https://pa.cms-lastwordmedia.com//wp-content/plugins/email-builder/cross.png" style={{width:'10px',cursor:'pointer',position: 'absolute',right:'10px',top:'10px'}} id={article.ID} onClick={this.props.onRemoveEditor}/>
                                                                                                </td>
                                                                                        </tr>
                                                                </tbody></table>
                                                        </td>
                                                </tr>
                                                 })}
                </tbody></table>
        </td>
</tr>
                                                
                                </tbody></table>
                        </td>
            </tr>
</tbody></table>
                                                              </td>
                                                           </tr>
                                                                                        <tr>
                                                 {this.props.sponsoredContent.length > 0 && this.props.showSponsoredContent === '1' ? <td style={{background: '#fff', position: 'relative'}}>
                                                                                                <div dangerouslySetInnerHTML={{__html:this.props.sponsoredContent}}></div>
                                                                                                <img src="https://pa.cms-lastwordmedia.com//wp-content/plugins/email-builder/cross.png" style={{width:'10px',cursor:'pointer',position: 'absolute',right:'10px',top:'10px'}} id="Sponsored_Content" onClick={this.props.onRemoveStatic}/>
                                                                                                </td>: ''}
                                                                                        </tr>
                                                           <tr>
        <td style={{padding:'0px 10px'}}>
        <table className="device_innerblock" style={{width:'728px', textAlign:'center'}}>
                <tr>
                        <td style={{textAlign:'left',padding:'0px 6px 6px 6px',color: '#000000', fontFamily:'Arial, Helvetica, sans-serif',fontSize: '18px',fontWeight:'bold'}}><font style={{fontFamily:'Arial, Helvetica, sans-serif'}}>Other stories from Last Word</font></td>
                </tr>
        </table></td>
</tr>
<tr>
        <td style={{padding:'0px 10px 0px 10px'}}>
        <table className="device_innerblock" style={{width: '728px', textAlign:'center'}}>
                <tr>
                        <td>{this.props.site === 'wp_2_' || this.props.site === 'wp_3_' || this.props.site === 'wp_4_' ?
                                <div className="section_content component_block" style={{display: 'inline', float: 'left'}} id="component_718ab570-2cbc-4ab9-b7a9-0e8c52ab225b">
<div className ="inner_section_content">
         <table className="footer_block" style={{width: '235px', textAlign: 'left'}}>
        <tr>
                <td style={{padding:'10px 10px 10px 10px'}}>
                <table style={{width: '100%'}}>
                        <tr>
                                <td style={{padding: '0px 0px 10px 0px', textAlign: 'left'}}>
                                        <a href="http://www.expertinvestoreurope.com" target="_blank"><img alt="Expert Investor" src="http://assets.kreatio.net/portfolio_adviser/images/eie_newsletter.jpg" title="Expert Investor"/></a>
                                </td>
                        </tr>
                        <tr>
                                <td style={{lineHeight: '14px',fontSize: '14px',padding:'0px 0px 5px 0px'}}>
                                        {this.props.selectedStoryArticles.length > 0 && _.filter(this.props.selectedStoryArticles, art => art.site === 'wp_5_').length > 0 ?
                                         <a href={_.filter(this.props.selectedStoryArticles, art => art.site === 'wp_5_')[0].guid} style={{color:'#000000',textDecoration: 'none',fontFamily:'Arial, Helvetica, sans-serif'}} target="_blank" title="Murky future for UK companies despite bumper profits"><font style={{fontFamily:'Arial, Helvetica, sans-serif'}}>{_.filter(this.props.selectedStoryArticles, art => art.site === 'wp_5_')[0].post_title}</font></a>
                                        : ''}
                                </td>
                        </tr>
                        <tr>
                                <td style={{padding: '10px 0px 0px 0px', textAlign: 'left'}}>
                                <table className="more" style={{width:'75px', textAlign: 'left'}}>
                                        <tr>
                                                <td style={{padding:'3px 10px 3px 10px',background:'#d4d4d4',textAlign:'left'}}><a className="more_from" href="http://www.portfolio-adviser.com" target="_blank" style={{color:'#000000',textDecoration: 'none',lineHeight: '14px',fontSize: '12px',fontFamily:  'Arial, Helvetica, sans-serif',fontWeight:'bold'}}><font style={{fontFamily:'Arial, Helvetica, sans-serif'}}>More Info</font></a></td>
                                        </tr>
                                </table></td>
                        </tr>
                </table></td>
        </tr>
</table>
</div>
</div> : ''}
                                                 {this.props.site === 'wp_2_' || this.props.site === 'wp_3_' || this.props.site === 'wp_5_' ?
                                <div className="section_content component_block" style={{display: 'inline', float: 'left'}} id="component_dda127db-bd7e-4399-8c75-1500c688370b">
<div className ="inner_section_content">
         <table className="footer_block" style={{width: '235px', textAlign: 'left'}}>
        <tr>
                <td style={{padding:'10px 0px 10px 0px'}}>
                <table style={{width: '100%'}}>
                        <tr>
                                <td style={{padding: '0px 0px 10px 0px', textAlign: 'left'}}>
                                        <a href="http://www.fundselectorasia.com" target="_blank"><img alt="Fund Selector Asia" src="http://www.expertinvestoreurope.com/images/fsa_newsletter.jpg" title="Fund Selector Asia" /></a>
                                </td>
                        </tr>
                        <tr>
                                <td style={{lineHeight: '14px',fontSize: '14px',padding:'0px 0px 5px 0px'}}>	
                                        {this.props.selectedStoryArticles.length > 0 && _.filter(this.props.selectedStoryArticles, art => art.site === 'wp_4_').length > 0 ?
                                         <a href={_.filter(this.props.selectedStoryArticles, art => art.site === 'wp_4_')[0].guid} style={{color:'#000000',textDecoration: 'none',fontFamily:'Arial, Helvetica, sans-serif'}} target="_blank" title="Murky future for UK companies despite bumper profits"><font style={{fontFamily:'Arial, Helvetica, sans-serif'}}>{_.filter(this.props.selectedStoryArticles, art => art.site === 'wp_4_')[0].post_title}</font></a>
                                        : ''}
                                </td>
                        </tr>
                        <tr>
                                <td style={{padding: '10px 0px 0px 0px', textAlign: 'left'}}>
                                <table className="more" style={{width:'75px', textAlign: 'left'}}>
                                        <tr>
                                                <td style={{padding:'3px 10px 3px 10px', textAlign:'left', background: '#d4d4d4'}}><a className="more_from" href="http://www.fundselectorasia.com" target="_blank" style={{color:'#000000',textDecoration: 'none',lineHeight: '14px',fontSize: '12px',fontFamily:  'Arial, Helvetica, sans-serif',fontWeight:'bold'}}><font style={{fontFamily:'Arial, Helvetica, sans-serif'}}>More Info</font></a></td>
                                        </tr>
                                </table></td>
                        </tr>
                </table></td>
        </tr>
</table>
</div>
</div> : ''}
                                                 {this.props.site === 'wp_2_' || this.props.site === 'wp_4_' || this.props.site === 'wp_5_' ? 
                                <div className="section_content component_block" style={{display: 'inline', float: 'left'}} id="component_aaaf6c07-a96c-409e-a6f1-77b7bcf5ba4f">
<div className ="inner_section_content">
         <table className="footer_block footer_last" style={{width: '235px', textAlign: 'right'}}>
        <tr>
                <td style={{padding:'10px 0px 10px 0px'}}>
                <table style={{width: '100%', textAlign: 'left'}}>
                        <tr>
                                <td style={{padding: '0px 0px 10px 0px', textAlign: 'left'}}>
                                        <a href="http://www.international-adviser.com" target="_blank"><img alt="International Adviser" src="http://www.expertinvestoreurope.com/images/ia_newsletter.png" title="International Adviser" /></a>
                                </td>
                        </tr>
                        <tr>
                                <td style={{lineHeight: '14px',fontSize: '14px',padding:'0px 0px 5px 0px'}}>
                                        {this.props.selectedStoryArticles.length > 0 && _.filter(this.props.selectedStoryArticles, art => art.site === 'wp_3_').length > 0 ?
                                         <a href={_.filter(this.props.selectedStoryArticles, art => art.site === 'wp_3_')[0].guid} style={{color:'#000000',textDecoration: 'none',fontFamily:'Arial, Helvetica, sans-serif'}} target="_blank" title="Murky future for UK companies despite bumper profits"><font style={{fontFamily:'Arial, Helvetica, sans-serif'}}>{_.filter(this.props.selectedStoryArticles, art => art.site === 'wp_3_')[0].post_title}</font></a>
                                        : ''}
                                </td>
                        </tr>
                        <tr>
                                <td style={{padding: '10px 0px 0px 0px', textAlign: 'left'}}>
                                <table className="more" style={{width:'75px', textAlign: 'left'}}>
                                        <tr>
                                                <td style={{padding:'3px 10px 3px 10px', background: '#d4d4d4', textAlign: 'left'}}><a className="more_from" href="http://www.international-adviser.com/" target="_blank" style={{color:'#000000',textDecoration: 'none',lineHeight: '14px',fontSize: '12px',fontFamily:  'Arial, Helvetica, sans-serif',fontWeight:'bold'}}><font style={{fontFamily:'Arial, Helvetica, sans-serif'}}>More Info</font></a></td>
                                        </tr>
                                </table></td>
                        </tr>
                </table></td>
        </tr>
</table>
</div>
</div> : ''}
                                                 {this.props.site === 'wp_3_' || this.props.site === 'wp_4_' || this.props.site === 'wp_5_' ?
<div className="section_content component_block" id="component_aaaf6c07-a96c-409e-a6f1-77b7bcf5ba4f">
<div className ="inner_section_content">
<table className="footer_block footer_last" style={{width: '235px', textAlign: 'right'}}>
<tr>
<td style={{padding:'10px 0px 10px 0px'}}>
<table style={{width: '100%', textAlign: 'left'}}>
<tr>
<td style={{padding: '0px 0px 10px 0px', textAlign: 'left'}}>
        <a href="http://www.international-adviser.com" target="_blank"><img alt="International Adviser" src="http://assets.kreatio.net/international_adviser/images/pa_newsletter.jpg" title="Portfolio Adviser" /></a>
</td>
</tr>
<tr>
<td style={{lineHeight: '14px',fontSize: '14px',padding:'0px 0px 5px 0px'}}>
        {this.props.selectedStoryArticles.length > 0 && _.filter(this.props.selectedStoryArticles, art => art.site === 'wp_2_').length > 0 ?
         <a href={_.filter(this.props.selectedStoryArticles, art => art.site === 'wp_2_')[0].guid} style={{color:'#000000',textDecoration: 'none',fontFamily:'Arial, Helvetica, sans-serif'}} target="_blank" title="Murky future for UK companies despite bumper profits"><font style={{fontFamily:'Arial, Helvetica, sans-serif'}}>{_.filter(this.props.selectedStoryArticles, art => art.site === 'wp_2_')[0].post_title}</font></a>
        : ''}
</td>
</tr>
<tr>
<td style={{padding: '10px 0px 0px 0px', textAlign: 'left'}}>
<table className="more" style={{width:'75px', textAlign: 'left'}}>
        <tr>
                <td style={{padding:'3px 10px 3px 10px', background: '#d4d4d4', textAlign: 'left'}}><a className="more_from" href="http://www.international-adviser.com/" target="_blank" style={{color:'#000000',textDecoration: 'none',lineHeight: '14px',fontSize: '12px',fontFamily:  'Arial, Helvetica, sans-serif',fontWeight:'bold'}}><font style={{fontFamily:'Arial, Helvetica, sans-serif'}}>More Info</font></a></td>
        </tr>
</table></td>
</tr>
</table></td>
</tr>
</table>
</div>
</div> : ''}
                        </td>
                </tr>
        </table></td>
</tr>
                                                           <tr>
                                                                                                <td style={{padding:'0px 9px; 0px 9px'}}>
                                                                                                        <table className="device_innerblock" style={{width:'728px', textAlign: 'center'}}>
                                                                                                                        <tr>
                                                                                                                                <td style={{padding:'10px 0px 10px 0px', textAlign: 'center'}}>
                                                                                                                                </td>
                                                                                                                        </tr>
                                                                                                        </table>
                                                                                                </td>
                                                                                        </tr>
                                                                                        {this.props.staticHighlight === 'footer' ? <tr><td style={{ animation : 'blink .5s step-end infinite alternate', border: '2px solid'}}><div><br/></div></td></tr> : ''}
                                                                                        {this.props.footerLeaderboard.length > 0 && this.props.showFooterLeaderboard === '1' ? <tr>
                                                                                          <td style={{position: 'relative', background: '#fff'}}>
                                                                                           <div dangerouslySetInnerHTML={{__html:this.props.footerLeaderboard}}></div>
                                                                                          <img src="https://pa.cms-lastwordmedia.com//wp-content/plugins/email-builder/cross.png" style={{width:'10px',cursor:'pointer',position: 'absolute',right:'10px',top:'10px'}} id="Footer_Leaderboard" onClick={this.props.onRemoveStatic}/>
                                                                                          </td>
                                                                                        </tr> : ''}
                                                           <tr>
                                                              <td style={{padding: '15px 15px 15px 15px', background: '#000'}} className="footer">
                                                                                                <table style={{width:'100%', textAlign: 'left'}} className="footer_content">
                                                                                                        <tr>
                                                                                                                <td style={{padding:'0px 0px 10px 0px', textAlign: 'left'}}>
                                                                                                                        <table style={{textAlign: 'left', margin: '0px', width: '140px'}} width="140" className="social_icon">
                                                                                                                                <tr>
                                                                                                                                        <td style={{textAlign: 'left'}}><a href="https://plus.google.com/+LastWordMediaLondon/" target="_blank"><img src="https://pa.cms-lastwordmedia.com/wp-content/uploads/email-template-images/newsletter-g.jpg" alt="gp" style={{display:'block'}}/></a></td>
                                                                                                                                        <td style={{textAlign: 'left'}}><a href="http://www.expertinvestoreurope.com/feed/rss" target="_blank"><img src="https://pa.cms-lastwordmedia.com/wp-content/uploads/email-template-images/newsletter-r.jpg" alt="rss" style={{display:'block'}} /></a></td>
                                                                                                                                        <td style={{textAlign: 'left'}}><a href="https://twitter.com/Expert_Investor" target="_blank"><img src="https://pa.cms-lastwordmedia.com/wp-content/uploads/email-template-images/newsletter-t.jpg"  alt="tw" style={{display:'block'}} /></a></td>
                                                                                                                                        <td style={{textAlign: 'left'}}><a href="https://www.facebook.com/LastWordMedia" target="_blank"><img src="https://pa.cms-lastwordmedia.com/wp-content/uploads/email-template-images//newsletter-f.jpg"  alt="fb" style={{display:'block'}}/></a></td>
                                                                                                                                        <td style={{textAlign: 'left'}}><a href="https://www.linkedin.com/company/expert-investor-europe" target="_blank"><img src="https://pa.cms-lastwordmedia.com/wp-content/uploads/email-template-images/newsletter-i.jpg"  alt="in" style={{display:'block'}}/></a></td>
                                                                                                                                </tr>
                                                                                                                        </table>
                                                                                                                </td>
                                                                    </tr>
                                                                    <tr>
                                                                                <td style={{color:'#fff',fontFamily:'Arial, Helvetica, sans-serif',fontSize:'11px',textDecoration: 'none',fontWeight: 'bold',padding:'0px 0px 10px 0px'}}>View the latest digital edition by downloading our magazine app available at:</td>
                                                                        </tr>
                                                                    <tr>
                                                                        <td style={{padding:'0px 0px 5px 0px', textAlign: 'left'}}>
                                                                                <table style={{margin: '0px', width:'265px', textAlign: 'left'}} className="social_icon" width="265">
                                                                                        <tr>
                                                                                                <td style={{textAlign:'left'}}><a href="https://itunes.apple.com/us/app/expert-investor-europe-for/id979169105?mt=8" target="_blank"><img src="https://pa.cms-lastwordmedia.com/wp-content/uploads/email-template-images/appstore.png" alt="img" style={{display:'block',maxWidth:'100%'}}/></a></td>
                                                                                                <td style={{textAlign: 'right'}}><a href="https://play.google.com/store/apps/details?id=com.lastwordmedia.eie" target="_blank"><img src="https://pa.cms-lastwordmedia.com/wp-content/uploads/email-template-images/googleplay.png" alt="img" style={{display:'block',maxWidth:'100%'}}/></a></td>
                                                                                        </tr>
                                                                                </table>
                                                                        </td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td>
                                                                                        <table width="100%">
                                                                                                <tr>
                                                                                                        <td className="footer_left" style={{padding:'0px 20px 0px 0px', textAlign: 'left', width: '80%'}}>
                                                                                                                <table width="100%">
                                                                                                                        <tr>
                                                                                                                                <td style={{color:'#fff',fontFamily:'Arial, Helvetica, sans-serif',fontSize:'11px',textDecoration: 'none',fontWeight: 'bold',padding:'0px 0px 3px 0px'}}> If you wish to unsubscribe from this email, <a href="[*link.prefill_url(1)*]" style={{color:'#FFFFFF',textDecoration: 'none',fontFamily: 'Arial, Helvetica, sans-serif'}}>please click here</a></td>
                                                                                                                        </tr>
                                                                                                                        <tr>
                                                                                                                                                                <td style={{padding:'0px 0px 10px 0px', color:'#fff',fontFamily:'Arial, Helvetica, sans-serif',fontSize:'11px',textDecoration: 'none',fontWeight: 'bold'}}>Do not reply to this email.</td>
                                                                                                                                                        </tr>
                                                                                                                                                        <tr>
                                                                                                                                                                <td style={{padding:'0px 0px 10px 0px', color:'#C2C2C2',fontFamily:'Arial, Helvetica, sans-serif',fontSize:'11px'}}><font style={{fontFamily:'Arial, Helvetica, sans-serif'}}><a href="http://www.expertinvestoreurope.com/static/privacy-policy" style={{color:'#FFFFFF',textDecoration: 'none',fontFamily: 'Arial, Helvetica, sans-serif'}}>Privacy policy </a> 
                                                                                                                                                                  | <a href="http://www.expertinvestoreurope.com" target="_blank" style={{color:'#FFFFFF',textDecoration: 'none',fontFamily: 'Arial, Helvetica, sans-serif'}}> Terms &#38; conditions.</a></font></td>
                                                                                                                                                        </tr>
                                                                                                                                                        <tr>
                                                                                                                                                                <td style={{color:'#fff',fontFamily: 'Arial, Helvetica, sans-serif',fontSize:'10px',padding:'0px 0px 3px 0px'}}><font style={{fontFamily:'Arial, Helvetica, sans-serif'}}> Published by Last Word Media Limited, Fleet House, 1st Floor, 59-61 Clerkenwell Road, London, EC1M 5LA. Copyright (c) 2017.</font></td>
                                                                                                                                                        </tr>
                                                                                                                                                        <tr>
                                                                                                                                                                <td style={{color:'#fff',fontFamily:'Arial, Helvetica, sans-serif',fontSize:'10px'}}><font style={{fontFamily:'Arial, Helvetica, sans-serif'}}>All rights reserved. Company Reg. No. 05573633. VAT. No. 672 411 728.</font></td>
                                                                                                                                                        </tr>
                                                                                                                 </table>
                                                                                                        </td>
                                                                                                        <td className="footer_left" style={{width: '20%', textAlign:'right'}}><a href="http://www.lastwordmedia.com" target="_blank"><img src="https://pa.cms-lastwordmedia.com/wp-content/uploads/email-template-images/newsletter_lastword1.png" alt="logo" style={{maxWidth: '100%',display:'block'}} /></a></td>
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
