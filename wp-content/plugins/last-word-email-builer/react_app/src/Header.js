import React, { Component } from 'react';

class Header extends Component {
  state = { 
   sites: [
    {name: 'Portfolio Advisor', value: 'wp_2_'},
    {name: 'International Advisor', value: 'wp_3_'},
    {name: 'Fund Selector Asia', value: 'wp_4_'},
    {name: 'Expert Investor Europe', value: 'wp_5_'}
   ]
  };

  onChangePage = (event) => {
    event.preventDefault();
    this.props.onChangePage(event.target.name);
  }

  onChange = (event) => {
    const { name, value } = event.target;
    this.props.onSetSite(value);
  }

  render() {
    return (
     <nav className="navbar navbar-default">
        <div className="container-fluid">
          <div className="navbar-header">
            <button type="button" className="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span className="sr-only">Toggle navigation</span>
              <span className="icon-bar"></span>
              <span className="icon-bar"></span>
              <span className="icon-bar"></span>
            </button>
            <a className="navbar-brand" href="#">Last Word (Logo)</a>
          </div>
          <div id="navbar" className="navbar-collapse collapse">
            <ul className="nav navbar-nav navbar-right">
              <li>
              <select name="template" className="form-control" value={this.props.site || ''} onChange={this.onChange} style={{marginTop: '10px'}}>
               {this.state.sites.map((site,key) => {
                return <option key={key} value={site.value}>{site.name}</option>
               })}
              </select>
              </li>
              <li><a href="" name="Dashboard" onClick={this.onChangePage}>Home <span className="sr-only">(current)</span></a></li>
              { this.props.currentPage !== 'CreateEmail' ? <li><a href="" name="CreateEmail" onClick={this.onChangePage}>Create Newsletter</a></li> : ''}
            </ul>
          </div>
        </div>
      </nav>
    );
  }
}

export default Header;
