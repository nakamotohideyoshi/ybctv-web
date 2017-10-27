import React, { Component } from 'react';
import PropTypes from 'prop-types';
import { DropTarget } from 'react-dnd';
import ItemTypes from './ItemTypes';
import _ from 'lodash';
import $ from 'jquery';
import Config from './Config';
import Guid from 'guid';


class SocialMediaComponent extends Component {
static propTypes = {
   site: PropTypes.any.isRequired
 };
render() {
      return (
        <table style={{textAlign: 'left',margin: '0px', width: '80px'}} data-align="left" data-width="80" className="social_icon">
                <tr>
                        {this.props.site === 'wp_2_'? <td style={{textAlign: 'left'}} data-align="left"><a href="https://twitter.com/PortfAdviser" target="_blank"><img src="https://pa.cms-lastwordmedia.com/wp-content/uploads/email-template-images/newsletter-t.jpg"  alt="tw" style={{display:'block'}} /></a></td> : ''}
                        {this.props.site === 'wp_3_'? <td style={{textAlign: 'left'}} data-align="left"><a href="https://twitter.com/IntAdviser" target="_blank"><img src="https://pa.cms-lastwordmedia.com/wp-content/uploads/email-template-images/newsletter-t.jpg"  alt="tw" style={{display:'block'}} /></a></td> : ''}
                        {this.props.site === 'wp_4_'? <td style={{textAlign: 'left'}} data-align="left"><a href="https://twitter.com/fundasia" target="_blank"><img src="https://pa.cms-lastwordmedia.com/wp-content/uploads/email-template-images/newsletter-t.jpg"  alt="tw" style={{display:'block'}} /></a></td> : ''}
                        {this.props.site === 'wp_5_'? <td style={{textAlign: 'left'}} data-align="left"><a href="https://twitter.com/Expert_Investor" target="_blank"><img src="https://pa.cms-lastwordmedia.com/wp-content/uploads/email-template-images/newsletter-t.jpg"  alt="tw" style={{display:'block'}} /></a></td> : ''}
                        <td style={{textAlign: 'left'}} data-align="left"><a href="https://www.facebook.com/LastWordMedia" target="_blank"><img src="https://pa.cms-lastwordmedia.com/wp-content/uploads/email-template-images//newsletter-f.jpg"  alt="fb" style={{display:'block'}}/></a></td>
                        {this.props.site === 'wp_2_'? <td style={{textAlign: 'left'}} data-align="left"><a href="https://www.linkedin.com/company/portfolio-adviser" target="_blank"><img src="https://pa.cms-lastwordmedia.com/wp-content/uploads/email-template-images/newsletter-i.jpg"  alt="in" style={{display:'block'}}/></a></td>: ''}
                        {this.props.site === 'wp_3_'? <td style={{textAlign: 'left'}} data-align="left"><a href="https://www.linkedin.com/company/international-adviser" target="_blank"><img src="https://pa.cms-lastwordmedia.com/wp-content/uploads/email-template-images/newsletter-i.jpg"  alt="in" style={{display:'block'}}/></a></td>: ''}
                        {this.props.site === 'wp_4_'? <td style={{textAlign: 'left'}} data-align="left"><a href="https://www.linkedin.com/company/fund-selector-asia" target="_blank"><img src="https://pa.cms-lastwordmedia.com/wp-content/uploads/email-template-images/newsletter-i.jpg"  alt="in" style={{display:'block'}}/></a></td>: ''}
                        {this.props.site === 'wp_5_'? <td style={{textAlign: 'left'}} data-align="left"><a href="https://www.linkedin.com/company/expert-investor-europe" target="_blank"><img src="https://pa.cms-lastwordmedia.com/wp-content/uploads/email-template-images/newsletter-i.jpg"  alt="in" style={{display:'block'}}/></a></td>: ''}
                </tr>
        </table>
    );
  }
}

export default SocialMediaComponent;
