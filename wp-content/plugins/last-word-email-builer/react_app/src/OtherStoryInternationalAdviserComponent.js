import React, { Component } from 'react';
import _ from 'lodash';

class OtherStoryInternationalAdviserComponent extends Component {
  state = { 
  };

  render() {
    return (
      <div className="section_content component_block" style={{float:'left',display: 'inline'}} id="component_dda127db-bd7e-4399-8c75-1500c688370c">
<div className ="inner_section_content">
<table data-width="235" style={{width: '235px', textAlign: 'right'}} data-align={this.props.float} class="footer_block">
<tr>
<td style={{padding:'10px 0px 10px 0px'}}>
<table style={{width: '100%', textAlign: 'left'}} data-width="100%">
<tr>
      <td style={{padding: '0px 0px 10px 0px', textAlign: 'left'}} data-align="left">
              <a href="http://www.international-adviser.com/" target="_blank"><img alt="International Adviser" src="https://pa.cms-lastwordmedia.com/wp-content/uploads/email-template-images/ia_newsletter.png" title="International Adviser" /></a>
      </td>
</tr>
{this.props.selectedStoryArticles.wp_3_.articles.map((article, key) => {
return <tr>
<td style={{lineHeight: '14px',fontSize: '14px',padding:'0px 0px 5px 0px'}}>
 <a href={article.guid} style={{color:'#000000',textDecoration: 'none',fontFamily:'Arial, Helvetica, sans-serif'}} target="_blank" title="Murky future for UK companies despite bumper profits"><font style={{fontFamily:'Arial, Helvetica, sans-serif'}}>{article.post_title.replace(/^(.{20}[^\s]*).*/, "$1")}...</font></a>
</td>
</tr>
})}
<tr>
      <td style={{padding: '10px 0px 0px 0px', textAlign: 'left'}} data-align="left">
      <table className="more" style={{width:'75px', textAlign: 'left'}} data-align="left" data-width="75">
              <tr>
                      <td style={{padding:'3px 10px 3px 10px', background: '#d4d4d4', textAlign: 'left'}} data-width="70" data-align="left" data-bgcolor="#d4d4d4"><a className="more_from" href="http://www.international-adviser.com/" target="_blank" style={{color:'#000000',textDecoration: 'none',lineHeight: '14px',fontSize: '12px',fontFamily:  'Arial, Helvetica, sans-serif',fontWeight:'bold'}}><font style={{fontFamily:'Arial, Helvetica, sans-serif'}}>More Info</font></a></td>
              </tr>
      </table></td>
</tr>
</table></td>
</tr>
</table>
</div>
</div> 
    );
  }
}

export default OtherStoryInternationalAdviserComponent;
