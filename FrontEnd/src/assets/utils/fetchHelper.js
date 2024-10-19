const API_URL = import.meta.env.VITE_API_BASE_URL;


// query de metodos sin body y  sin necesidad de token
export const simpleQuery = async (path, method = 'GET') => {
  const url = `${API_URL}${path}`
  return fetch(url, {
    method,
    headers: {
      'Content-Type': 'application/json',
    }
  }).then(res => res.json())
}
// query de metodos con body sin necesidad de token
export const Query = async (path, data = null, method = 'POST') => {
  const url = `${API_URL}${path}`
  return fetch(url, {
    method,
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify(data),
  }).then(res => {
    console.log(res);
   return res.json()
  })
}

// query de metodos sin body con necesidad de token
export const simpleAuthQuery = async (path, method = 'GET') => {
  const url = `${API_URL}${path}`;
  const TOKEN = JSON.parse(localStorage.getItem('authToken'));
  if (!TOKEN) return Promise.reject(new Error('Token no disponible'));
  return fetch(url, {
    method,
    headers: {
      Authorization: `Bearer ${TOKEN}`,
      'Content-Type': 'application/json',
    }
  }).then(res => res.json())
}

// query de metodos con body y token
export const AuthQuery = async (path, data = null, method = 'POST') => {
  const url = `${API_URL}${path}`;
  const TOKEN = JSON.parse(localStorage.getItem('authToken'));
  if (!TOKEN) return Promise.reject(new Error('Token no disponible'));
  return fetch(url, {
    method,
    headers: {
      Authorization: `Bearer ${TOKEN}`,
      'Content-Type': 'application/json',
    },
    body: JSON.stringify(data),
  }).then(res => res.json())
}



