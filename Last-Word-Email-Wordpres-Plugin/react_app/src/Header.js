import React, { Component } from 'react';

class Header extends Component {
  state = { };

  onChangePage = (event) => {
    event.preventDefault();
    this.props.onChangePage(event.target.name);
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
